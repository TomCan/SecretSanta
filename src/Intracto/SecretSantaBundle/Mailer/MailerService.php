<?php

namespace Intracto\SecretSantaBundle\Mailer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Intracto\SecretSantaBundle\Entity\Entry;
use Intracto\SecretSantaBundle\Entity\Pool;

class MailerService
{
    /** @var \Swift_Mailer */
    public $mailer;
    /** @var EntityManager */
    public $em;
    /** @var EngineInterface */
    public $templating;
    /** @var  TranslatorInterface */
    public $translator;
    /** @var \Symfony\Bundle\FrameworkBundle\Routing\Router */
    public $routing;
    public $adminEmail;

    /**
     * @param \Swift_Mailer $mailer
     * @param EntityManager $em
     * @param EngineInterface $templating
     * @param TranslatorInterface $translator
     * @param Router $routing
     * @param $adminEmail
     */
    public function __construct(
        \Swift_Mailer $mailer,
        EntityManager $em,
        EngineInterface $templating,
        TranslatorInterface $translator,
        Router $routing,
        $adminEmail
    )
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;
        $this->translator = $translator;
        $this->routing = $routing;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Sends out all mails for a Pool
     *
     * @param Pool $pool
     */
    public function sendSecretSantaMailsForPool(Pool $pool)
    {
        $pool->setSentdate(new \DateTime('now'));
        $this->em->flush($pool);

        foreach ($pool->getEntries() as $entry) {
            $this->sendSecretSantaMailForEntry($entry);
        }
    }

    /**
     * Sends out mail for a Entry
     *
     * @param Entry $entry
     */
    public function sendSecretSantaMailForEntry(Entry $entry)
    {
        $this->translator->setLocale($entry->getPool()->getLocale());

        $message = $entry->getPool()->getMessage();
        $message = str_replace('(NAME)', $entry->getName(), $message);
        $message = str_replace('(ADMINISTRATOR)', $entry->getPool()->getOwnerName(), $message);

        $mail = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('emails.secretsanta.subject'))
            ->setFrom($this->adminEmail, $entry->getPool()->getOwnerName())
            ->setReplyTo([$entry->getPool()->getOwnerEmail() => $entry->getPool()->getOwnerName()])
            ->setTo($entry->getEmail(), $entry->getName())
            ->setBody(
                $this->templating->render(
                    'IntractoSecretSantaBundle:Emails:secretsanta.html.twig',
                    [
                        'message' => $message,
                        'entry' => $entry,
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->templating->render(
                    'IntractoSecretSantaBundle:Emails:secretsanta.txt.twig',
                    [
                        'message' => $message,
                        'entry' => $entry,
                    ]
                ),
                'text/plain'
            );
        $this->mailer->send($mail);
    }

    /**
     * @param Pool $pool
     */
    public function sendPoolMatchesToAdmin(Pool $pool)
    {
        $this->translator->setLocale($pool->getLocale());
        $this->mailer->send(\Swift_Message::newInstance()
            ->setSubject($this->translator->trans('emails.admin_matches.subject'))
            ->setFrom($this->adminEmail, $this->translator->trans('emails.sender'))
            ->setTo($pool->getOwnerEmail(), $pool->getOwnerName())
            ->setBody(
                $this->templating->render(
                    'IntractoSecretSantaBundle:Emails:admin_matches.html.twig',
                    [
                        'pool' => $pool,
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->templating->render(
                    'IntractoSecretSantaBundle:Emails:admin_matches.txt.twig',
                    [
                        'pool' => $pool,
                    ]
                ),
                'text/plain'
            )
        );
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendForgotManageLinkMail($email)
    {
        $results = $this->em->getRepository('IntractoSecretSantaBundle:Pool')->findAllAdminPools($email);

        if (count($results) == 0) {
            return false;
        }

        $poolLinks = [];
        foreach ($results as $result) {
            $text = $this->translator->trans('manage.title');

            if ($result['eventdate'] instanceof \DateTime) {
                $text .= ' (' . $result['eventdate']->format('d/m/Y') . ')';
            }

            $poolLinks[] = array(
                'url' => $this->routing->generate('pool_manage', ['listUrl' => $result['listurl']], Router::ABSOLUTE_URL),
                'text' => $text,
            );
        }

        $this->translator->setLocale($results[0]['locale']);

        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('emails.forgot_link.subject'))
            ->setFrom($this->adminEmail, $this->translator->trans('emails.sender'))
            ->setTo($email)
            ->setBody(
                $this->templating->render(
                    'IntractoSecretSantaBundle:Emails:forgotlink.html.twig',
                    [
                        'poolLinks' => $poolLinks,
                    ]
                ),
                'text/html'
            )
            ->addPart(

                $this->templating->render(
                    'IntractoSecretSantaBundle:Emails:forgotlink.txt.twig',
                    [
                        'poolLinks' => $poolLinks,
                    ]
                ),
                'text/plain'
            );
        $this->mailer->send($message);

        return true;
    }
}
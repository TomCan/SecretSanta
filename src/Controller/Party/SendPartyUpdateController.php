<?php

declare(strict_types=1);

namespace App\Controller\Party;

use App\Entity\Party;
use App\Mailer\MailerService;
use App\Service\ReportQueriesService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SendPartyUpdateController extends Controller
{
    /**
     * @Route("/send-party-update/{listurl}", name="send_party_update")
     * @Method("GET")
     */
    public function sendPartyUpdateAction(Party $party, ReportQueriesService $reportQueriesService, MailerService $mailerService)
    {
        $results = $reportQueriesService->fetchDataForPartyUpdateMail($party->getListurl());

        $mailerService->sendPartyUpdateMailForParty($party, $results);

        $this->addFlash('success', $this->get('translator')->trans('flashes.send_party_update.success'));

        return $this->redirectToRoute('party_manage', ['listurl' => $party->getListurl()]);
    }
}

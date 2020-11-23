<?php

namespace App\Controller;

use App\Form\Handler\ContactFormHandler;
use App\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @Template("Static/contact.html.twig")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request, ContactFormHandler $handler)
    {
        $form = $this->createForm(ContactType::class);

        if ($handler->handle($form, $request)) {
            return $this->redirectToRoute('homepage');
        }

        return ['form' => $form->createView()];
    }
}

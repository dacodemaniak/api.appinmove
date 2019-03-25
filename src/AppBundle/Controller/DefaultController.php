<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\Post("/processmail", name="processmail")
     */
    public function indexAction(Request $request)
    {
        
        $mailDatas = [
            ["libelle" => "Nom", "value" => $request->get("nom")],
            ["libelle" => "Société", "value" => $request->get("societe")],
            ["libelle" => "Email", "value" => $request->get("email")],
            ["libelle" => "Objet", "value" => $request->get("objet")],
            ["libelle" => "Message", "value" => $request->get("message")]
        ];
        
        // Générer l'e-mail pour l'envoi du lien de récupération
        $emailContent = $this->renderView(
            "@App/Email/mail.html.twig",
            [
                "mailDatas" => $mailDatas
            ]
        );
        
        if ($this->_sendMail($emailContent)) {
            return new View("Votre message a bien été envoyé et sera traité dans les meilleurs délais. Merci de votre confiance", Response::HTTP_OK);
        }
        
        return new View("Une erreur est survenue lors de l'envoi de votre message. Nous en sommes désolé.", Response::HTTP_INTERNAL_SERVER_ERROR);
        
    }
    
    /**
     * Génère les emails de confirmation de commande
     * @param string $content
     * @param string $customerEmailContent
     * @return boolean
     */
    private function _sendMail(string $content) {
        $mailer = $this->get("mailer");
        
        $message = (new \Swift_Message("Nouveau message à partir du site web"))
        ->setFrom("hello@lessoeurstheiere.com")
        ->setTo([
            "valerie.a@appinmove.com" => "AppInMove.com"
        ])
        ->setBcc([
            "jean-luc.a@web-projet.com" => "IDea Factory - survey team"
        ])
        ->setCharset("utf-8")
        ->setBody(
            $content,
            "text/html"
            );
        // Envoi le mail proprement dit
        if (($recipients = $mailer->send($message)) !== 0) {
            return true;
        }
        
        
        return false;
    }
}

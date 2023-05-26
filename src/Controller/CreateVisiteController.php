<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Entity\Visite;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateVisiteController extends AbstractController
{
    #[Route('/', name: 'app_create_visite')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $lesExpos = $doctrine->getRepository(Exposition::class)->findAll();
        $uneVisite = new Visite();
        $uneVisite->setNbVisiteursAdultes(0);
        $uneVisite->setNbVisiteursEnfants(0);
        $uneVisite->setDateHeureArrivee(new \DateTime());
        $message = "";
        //dd($uneVisite);
        if ($request->get('nbAdultes') !== null){
            $uneVisite->setNbVisiteursAdultes($request->get('nbAdultes'));
        }
        if ($request->get('nbEnfants') !== null){
            $uneVisite->setNbVisiteursEnfants($request->get('nbEnfants'));
        }

        foreach ($lesExpos as $expo) {
            if ($request->get($expo->getId()) !== null){
                $uneVisite->addExposition($expo);
            }
        }
        if ($request->get('valider') !== null){
            if ($uneVisite->getNbVisiteursAdultes() == 0 && $uneVisite->getNbVisiteursEnfants() == 0){
                $message = 'Saisir au moins un visiteur adulte ou enfant';
            } elseif ($uneVisite->getExposition()->count() == 0){
                $message = 'Cochez au mmoins une exposition';
            } else {
                $doctrine->getManager()->persist($uneVisite);
                $doctrine->getManager()->flush();
                return $this->render('create_visite/confirmVisite.html.twig', [
                    'uneVisite' => $uneVisite,
                ]);
            }

        }



        return $this->render('create_visite/index.html.twig', [
            'lesExpos' => $lesExpos,
            'uneVisite' => $uneVisite,
            'unMessage' => $message,
        ]);
    }
}

<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IniciController extends AbstractController
{

    #[Route("/",name:'inici')]
     public function inici(){
        return $this->render('inicio.html.twig');
     }

}

?>
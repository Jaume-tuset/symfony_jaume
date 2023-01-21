<?php
namespace App\Controller;

use App\Service\ServeiDadesEquips;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IniciController extends AbstractController
{
   private $equip;
    public function __construct(ServeiDadesEquips $equip)
    {
        $this->equip = $equip->get();
    }

    #[Route("/",name:'inici')]
     public function inici(){
      return $this->render('inicio.html.twig', array('equip' => $this->equip));
   }

}

?>
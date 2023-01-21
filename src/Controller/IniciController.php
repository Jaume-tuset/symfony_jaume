<?php
namespace App\Controller;

use App\Entity\Equip;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IniciController extends AbstractController
{
   #[Route('/' ,name:'inici')]
   public function inici(ManagerRegistry $doctrine)
   {
       $repositori = $doctrine->getRepository(Equip::class);
       $equips = $repositori->findAll();
       return $this->render('inici.html.twig',array('equips'=>$equips));
   }

}

?>
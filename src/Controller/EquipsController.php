<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ServeiDadesEquips;

class EquipsController extends AbstractController
{
    private $dadesEquips;
    private $equips;
    public function __construct($dadesEquips)
    {
        $this->equips = $dadesEquips->get();
    }

    #[Route('/equip/{codi<\d+>?1}',name:'dades_equip')]
     public function dades($codi){
        $resultat = array_filter(
            $this->equips,
            function ($dades) use ($codi) {
                return $dades["codi"]==$codi;
            }
        );

        if(count($resultat)>0){
            return $this->render('dades_equip.html.twig', array('dades' => array_shift($resultat)));
        }else{
            return $this->render('dades_equip.html.twig', array('dades' => array_shift($resultat)));
        }
     }
}

?>
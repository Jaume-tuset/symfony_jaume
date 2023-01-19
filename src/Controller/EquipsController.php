<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipsController
{
    private $equips = array(
        array("codi" => "1",
            "nom" => "Equipo Rojo",
            "cicle" => "DAW",
            "curs" => "22/23",
            "membres" => array("David", "Alejandro", "Jose", "Marta")),
        array("codi" => "2",
            "nom" => "Equipo Amarillo",
            "cicle" => "DAM",
            "curs" => "19/20",
            "membres" => array("Pepe", "Luis", "Silvia", "Anna")),
        array("codi" => "3",
            "nom" => "Equipo Naranja",
            "cicle" => "ASIX",
            "curs" => "20/21",
            "membres" => array("Pablo", "Lucas", "Sabrina", "Anastasia")),
        array("codi" => "4",
            "nom" => "Equipo Verde",
            "cicle" => "AMX",
            "curs" => "18/19",
            "membres" => array("Hernesto", "Hugo", "Alba", "Natalaia")),
    );
    
    #[Route('/equip/{codi}',name:'dades_equip')]
     public function dades($codi){
        $resultat = array_filter(
            $this->equips,
            function ($dades) use ($codi) {
                return $dades["codi"]==$codi;
            }
        );
        if(count($resultat)>0){
            $resposta = "";
            $resultat = array_shift($resultat);
            $mb = implode(" ",$resultat["membres"]);
            $resposta .= "<ul><li>" . $resultat["nom"] . "</li>" .
                "<li>" . $resultat["cicle"] . "</li>" .
                "<li>" . $resultat["curs"] . "</li>" .
                "<li>" . $mb . "</li></ul>";
            return new Response("<html><body>$resposta</body></html>");
        }else{
            return new Response("No s'ha trobat l'equip : ". $codi);
        }
     }
}

?>
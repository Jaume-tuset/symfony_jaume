<?php
namespace App\Controller;

use App\Entity\Equip;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/equip/{codi<\d+>?1}',name:'dades_equip',requirements: ['codi' => '\d+'])]
    public function dades(ManagerRegistry $doctrine,$codi=1)
    {
        $repositori = $doctrine->getRepository(Equip::class);
        $equip = $repositori->find($codi);
        
        if ($equip!=null)
            return $this->render('equip.html.twig', array('equip'=>$equip,'codi'=>$codi));
        else
            return $this->render('equip.html.twig', array('equip' => NULL,'codi'=>NULL));

    }


    #[Route('filtrarnotes/nota/{nota}', name:'filtro_nota',requirements:['codi'=>'\d+'])]
    public function fitrar(ManagerRegistry $doctrine,$nota=0) {
        
        $repositori = $doctrine->getRepository(Equip::class);
        $equips = $repositori->findByNote($nota);
        $equipssort=rsort($equips);
    
        if ($equips!=null)
            return $this->render('filtrar_notes_equip.html.twig', array('equips'=>$equips));
        else
            return $this->render('filtrar_notes_equip.html.twig', array('equips' => NULL));
    }



    #[Route('/equip/inserir' ,name:'inserir_equip')]
    public function inserir(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $equip = new Equip();
        $equip->setNom('Simarrets');
        $equip->setCicle('DAW');
        $equip->setCurs('22/23');
        $equip->setNota(9);
        $equip->setImatge('assets/img/equipos/simarrets.jpeg');
        $entityManager->persist($equip);

        try {
            $entityManager->flush();
            return $this->render('inserir_equip.html.twig', [
                'equips' => $equip,
                'error' => null,
            ]);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->render('inserir_equip.html.twig', [
                'equips' => $equip,
                'error' => $error,
            ]);
        }
    }

    #[Route('/equip/inserirmultiple' ,name:'inserir_equips')]
    public function inserirmultiple(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $equip1 = new equip();
        $equip1->setNom('Equip Cereza');
        $equip1->setCicle('DAW');
        $equip1->setCurs('22/23');
        $equip1->setNota(5.25);
        $equip1->setImatge('assets/img/equipos/rojo.jpeg');
        $entityManager->persist($equip1);

        $equip2 = new equip();
        $equip2->setNom('Equip Violeta');
        $equip2->setCicle('DAM');
        $equip2->setCurs('22/23');
        $equip2->setNota(4.4);
        $equip2->setImatge('assets/img/equipos/morado.jpeg');
        $entityManager->persist($equip2);

        $equip3 = new equip();
        $equip3->setNom('Equipo Azul');
        $equip3->setCicle('ASIR');
        $equip3->setCurs('22/23');
        $equip3->setNota(7.8);
        $equip3->setImatge('assets/img/equipos/verde.jpeg');
        $entityManager->persist($equip3);

        $equip4 = new equip();
        $equip4->setNom('Equipo Negro');
        $equip4->setCicle('ASIX');
        $equip4->setCurs('22/23');
        $equip4->setNota(3.7);
        $equip4->setImatge('assets/img/equipos/amarillo.jpeg');
        $entityManager->persist($equip4);

        $equips = [$equip1, $equip2, $equip3, $equip4];
        try {
            $entityManager->flush();
            return $this->render('inserir_equip_multiple.html.twig', [
                'equips' => $equips,
                'error' => null,
            ]);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->render('inserir_equip_multiple.html.twig', [
                'equips' => $equips,
                'error' => $error,
            ]);
        }
    }
}

?>

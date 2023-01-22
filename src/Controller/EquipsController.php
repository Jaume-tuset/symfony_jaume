<?php
namespace App\Controller;

use App\Entity\Equip;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ServeiDadesEquips;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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


    #[Route('/equip/nou/',name:'nou_equip')]
    public function nou(ManagerRegistry $doctrine){
      
        $error=null;
        $equip = new Equip();
        $formulari = $this->createFormBuilder($equip)
        ->add('nom', TextType::class)
        ->add('cicle', TextType::class)
        ->add('curs', TextType::class)
        ->add('Imatge', FileType::class)
        ->add('Nota', NumberType::class)
        ->add('save', SubmitType::class, array('label' => 'Enviar'))
        ->getForm();

        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $fitxer = $formulari->get('imatge')->getData();
            if ($fitxer) { // si s’ha indicat un fitxer al formulari
                $nomFitxer = "assets/img/equipos/".$fitxer->getClientOriginalName();
                //ruta a la carpeta de les imatges d’equips, relativa a index.php
                //aquest directori ha de tindre permisos d’escriptura
                $directori =
                $this->getParameter('kernel.project_dir')."/public/assets/img/equipos/";
            
                try {
                    $fitxer->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    $error=$e->getMessage();
                    return $this->render('nou_equip.html.twig', array(
                    'formulari' => $formulari->createView(), "error"=>$error));
                }
            
                $equip->setImatge($nomFitxer); // valor del camp imatge
            
            } else {//no hi ha fitxer, imatge per defecte
                $equip->setImatge('assets/img/equipos/equipPerDefecte.jpeg');
            }
            
            //hem d’assignar els camps de l’equip 1 a 1
            $equip->setNom($formulari->get('nom')->getData());
            $equip->setCicle($formulari->get('cicle')->getData());
            $equip->setCurs($formulari->get('curs')->getData());
            $equip->setNota($formulari->get('nota')->getData());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($equip);
            
            try{
                return $this->redirectToRoute('inici');
            } catch (\Exception $e) {
                $error=$e->getMessage();
                return $this->render('nou_equip.html.twig', array(
                'formulari' => $formulari->createView(), "error"=>$error));
            }
        }else{
            return $this->render('nou_equip.html.twig',
            array('formulari' => $formulari->createView(),"error"=>$error));
        }
    }
}

?>

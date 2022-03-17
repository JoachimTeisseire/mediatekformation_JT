<?php
namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NiveauxRepository;
use App\Form\NiveauxType;
use App\Entity\Niveaux;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of AdminFormationsController
 *
 * @author Joachim
 */
class AdminNiveauxController extends AbstractController{
        
    private const PAGENIVEAU = "admin/adminniveaux.html.twig";

    /**
     *
     * @var NiveauxRepository
     */
    private $repository;
    
    /**
     *
     * @var EntityManagerInterface
     */
    private $om;


    /**
     * 
     * @param NiveauxRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(NiveauxRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }

    /**
     * @Route("admin/adminniveaux", name="adminniveaux")
     * @return Response
     */
    public function index(): Response{
        $niveaux = $this->repository->findAll();
        return $this->render(self::PAGENIVEAU, [
            'niveaux' => $niveaux
        ]);
    }
    
    /**
     * @Route("/admin/adminniveaux/suppr/{id}", name="adminniveau.suppr")
     * @param Niveaux $niveau
     * @return Response
     */
    public function supprNiveau(Niveaux $niveau): Response{
        $this->om->remove($niveau);
        $this->om->flush();
       return $this->redirectToRoute('adminniveaux');
    }
    /**
     * @Route("/admin/adminniveaux/ajout", name="adminniveau.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajoutNiveau(Request $request): Response{
       $niveau = new Niveaux();
       $formNiveau = $this->createForm(NiveauxType::class, $niveau);
       
       $formNiveau->handleRequest($request);
       if($formNiveau->isSubmitted() && $formNiveau->isValid()){
       $this->om->persist($niveau);
       $this->om->flush();
       return $this->redirectToRoute('adminniveaux');
       }
       return $this->render("admin/ajoutniveau.html.twig",['niveau'=> $niveau,'formniveau'=> $formNiveau->createView()]);
    }
    
}
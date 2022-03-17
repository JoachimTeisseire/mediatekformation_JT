<?php
namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormationRepository;
use App\Form\FormationType;
use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of AdminFormationsController
 *
 * @author Joachim
 */
class AdminFormationsController extends AbstractController{
        
    private const PAGEFORMATIONS = "admin/adminformations.html.twig";

    /**
     *
     * @var FormationRepository
     */
    private $repository;
    
     /**
     *
     * @var EntityManagerInterface
     */
    private $om;

    /**
     * 
     * @param FormationRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(FormationRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }

    /**
     * @Route("admin/adminformations", name="adminformations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->repository->findAll();
        return $this->render(self::PAGEFORMATIONS, [
            'formations' => $formations
        ]);
    }
    
    /**
     * @Route("admin/adminformations/tri/{champ}/{ordre}", name="adminformations.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        $formations = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::PAGEFORMATIONS, [
           'formations' => $formations
        ]);
    }   
        
    /**
     * @Route("admin/adminformations/recherche/{champ}", name="adminformations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllContain($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
            $valeur = $request->get("recherche");
            $formations = $this->repository->findByContainValue($champ, $valeur);
            return $this->render(self::PAGEFORMATIONS, [
                'formations' => $formations
            ]);
        }
        return $this->redirectToRoute("formations");
    }  
    
    /**
     * @Route("admin/adminformations/formation/{id}", name="adminformations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->repository->find($id);
        return $this->render("admin/adminformation.html.twig", [
            'formation' => $formation
        ]);        
    }
    
    /**
     * @Route("/admin/adminformation/formation/edit/{id}", name="adminformation.edit")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function editFormation(Formation $formation, Request $request): Response{
       $formFormation = $this->createForm(FormationType::class, $formation);
       $formFormation->handleRequest($request);
       if($formFormation->isSubmitted()&& $formFormation->isValid()){
           $this->om->flush();
           return $this->redirectToRoute('adminformations');
       }
       return $this->render("admin/editformation.html.twig",
               ['formation' => $formation, 'formformation' => $formFormation->createView()
               ]);
    }
    
    /**
     * @Route("/admin/adminformation/formation/suppr/{id}", name="adminformation.suppr")
     * @param Formation $formation
     * @return Response
     */
    public function supprFormation(Formation $formation): Response{
       $this->om->remove($formation);
       $this->om->flush();
       return $this->redirectToRoute('admiformations');
    }
    
    /**
     * @Route("/admin/adminformation/ajout", name="adminformation.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajoutFormation(Request $request): Response{
       $formation = new Formation();
       $formFormation = $this->createForm(FormationType::class, $formation);
       
       $formFormation->handleRequest($request);
       if($formFormation->isSubmitted() && $formFormation->isValid()){
       $this->om->persist($formation);
       $this->om->flush();
       return $this->redirectToRoute('adminformations');
       }
       return $this->render("admin/ajoutformation.html.twig",['formation'=> $formation,'formformation'=> $formFormation->createView()]);
    }
}
<?php
namespace App\Controller\admin;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author emds
 */
class AdminAccueilController extends AbstractController{
    
    /**
     *
     * @var FormationRepository
     */
    private $repository;
    
    /**
     * 
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }    
    
    /**
     * @Route("/admin", name="adminaccueil")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->repository->findAllLasted(2);
        return $this->render("admin/adminaccueil.html.twig", [
            'formations' => $formations
        ]);  
    }
}

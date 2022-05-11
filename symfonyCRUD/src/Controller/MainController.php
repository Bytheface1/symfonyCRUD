<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("create", name="create")
     */
    public function create(Request $request, PersistenceManagerRegistry $doctrine){
        $crud = new Crud();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','Guardado Correctamente!');
        }
        return $this->render('main/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

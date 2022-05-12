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
    private $doctrine;
    
    public function __construct(PersistenceManagerRegistry $doctrine)
    {
        //parent::__construct($registry, Product::class);
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $data = $this->doctrine->getRepository(Crud::class)->findAll();
    
        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request){
        $crud = new Crud();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->doctrine->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','Guardado Correctamente!');

            return $this->redirectToRoute('main');
        }
        return $this->render('main/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, $id){

        $crud = $this->doctrine->getRepository(Crud::class)->find($id);
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->doctrine->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','Guardado Correctamente!');

            return $this->redirectToRoute('main');
        }
        return $this->render('main/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Request $request, $id){

        $data = $this->doctrine->getRepository(Crud::class)->find($id);
        $em = $this->doctrine->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','Borrado Correctamente!');

        return $this->redirectToRoute('main');
    }
}

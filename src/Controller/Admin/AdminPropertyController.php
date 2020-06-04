<?php

namespace App\Controller\Admin;

use App\Entity\Property;

use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\AdminPropertyController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class AdminPropertyController extends AbstractController{
  
        /**
        * @var PropertyRepository
        */
        private $repository;

        /**
        * @var EntityManager
        */
        private $em;
        
        public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
         {
            $this->repository=$repository;
            $this->em=$em;
         }


        /**
        * @Route ("/admin", name="admin_property_index")
        * return Response;
        */        
         public function index():Response       
         {
             $properties = $this->repository->findAll();
             
             return $this->render('admin/property/index.html.twig', compact('properties'));
         }
       
        /**
        * @Route ("/admin/property/create", name="admin_property_new")
        * return Response;
        */        
         public function new(Request $request):Response       
         {
             $property = new Property;

             $form =  $this->createForm(PropertyType::class, $property);    
             $form->handleRequest($request);  
               if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($property);   
                $this->em->flush();
                $this->addFlash('success', 'Bien créé avec success');

             return $this->redirectToRoute('admin_property_index');
            }    

             return $this->render('admin/property/new.html.twig', [
                      'property' => $property,
                      'form' => $form->createView()
             ] );
             

         }

        /**
        * @Route ("/admin/property/{id}", name="admin_property_edit", methods="POST|GET")
        * @param Property $property
        * @param Request $request
        * return Symfony\Component\HttpFoundation\Response;
        */

         public function edit(Property $property, Request $request): Response     
         {
             $form =  $this->createForm(PropertyType::class, $property);    
             $form->handleRequest($request);  
               if ($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();
                $this->addFlash('success', 'Bien modifié avec success');

             return $this->redirectToRoute('admin_property_index');
            }    

             return $this->render('admin/property/edit.html.twig', [
                      'property' => $property,
                      'form' => $form->createView()
             ] );
         }

        /**
        * @Route("/admin/property/{id}", name="admin_property_delete", methods={"DELETE"})
        */
        public function delete(Property $property, Request $request): Response
        {
            if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec success');
        }

        return $this->redirectToRoute('admin_property_index');
        } 

    }
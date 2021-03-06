<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;

use App\Form\ContactType;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


     class PropertyController extends AbstractController
     {
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
        * @Route ("/biens", name="property_index")
        * return Response
        */
         public function index(PaginatorInterface $paginator, Request $request):Response       
         {
          $search = new PropertySearch;

          $form =  $this->createForm(PropertySearchType::class, $search);    
          $form->handleRequest($request);   

             return $this->render('property/index.html.twig', [
                      'current_menu' => 'properties',
                      'properties' => $this->repository->paginateAllVisible($search, $request->query->getInt('page', 1)),
                      'form' => $form->createView()
             ] );
         }

         
        /**
        * @Route ("/biens/{slug}-{id}", name="property_show", requirements = {"slug": "[a-z0-9\-]*"})
        * return Response
        * @param Property $property
        */
         public function show(Property $property, string $slug, Request $request, ContactNotification $notification):Response  
         {
            if($property->getSlug() !== $slug){
              return $this->redirectToRoute('property_show', [
                  'id'=> $property->getId(),
                  'slug' => $property->getSlug()
               ], 301);
            }

            $contact = new Contact;
            $contact->setProperty($property);
            $form =  $this->createForm(ContactType::class, $contact); 
            $form->handleRequest($request); 

            if ($form->isSubmitted() && $form->isValid()) {             
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé');
              return $this->redirectToRoute('property_show', [
                  'id'=> $property->getId(),
                  'slug' => $property->getSlug()
               ]);
            }
            
              return $this->render('property/show.html.twig', [
                     'property' => $property,
                     'current_menu' => 'properties',
                     'form' => $form->createView()
               ]);
         } 

     }

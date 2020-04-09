<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;

use App\Form\PropertySearchType;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
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

          // $properties = $this->repository->findAllVisible();        
           $properties =  $paginator->paginate($this->repository->findAllVisibleQuery($search), 
           $request->query->getInt('page', 1), /*page number*/
            12
            );

             return $this->render('property/index.html.twig', [
                      'current_menu' => 'properties',
                      'properties' => $properties,
                      'form' => $form->createView()
             ] );
         }

         
        /**
        * @Route ("/biens/{slug}-{id}", name="property_show", requirements = {"slug": "[a-z0-9\-]*"})
        * return Response
        * @param Property $property
        */
         public function show(Property $property, string $slug, CacheManager $cacheManager, UploaderHelper $helper):Response  
         {
            if($property->getSlug() !== $slug){
              return $this->redirectToRoute('property_show', [
                  'id'=> $property->getId,
                  'slug' => $property->getSlug
               ], 301);
            }
           // $property = $this->repository->find($id);
             return $this->render('property/show.html.twig', [
                     'property' => $property,
                      'current_menu' => 'properties'
                        ] );
         } 
         /*
           public function index(PropertyRepository $repository)      
         {
             $property = $this->repository->findAllVisible();

             return $this->render('property/index.html.twig', [
                      'current_menu' => 'properties'
             ] );
         }*/
     }

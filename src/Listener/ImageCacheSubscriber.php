<?php

namespace App\Listener;

use App\Entity\Picture;
use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;



class ImageCacheSubscriber implements EventSubscriber 
{

    /**
    *  @var UploaderHelper
    */
    private $uploaderHelper;

    /**
    *  @var CacheManager
    */
    private $cacheManager;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper){
      
        $this->uploaderHelper = $uploaderHelper;
        $this->cacheManager = $cacheManager;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }
    
    /**
    * @param LifecycleEventArgs $args
    * @return void
    */
    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
 
        if (!$entity instanceof Picture ) {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    /**
     * @param PreUpdateEventArgs $args
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
      
          if(!$entity instanceof Picture){
            return;
        }

        /*  $this->imageFile = $imageFile;
        if (null !== $imageFile)
          =
        if ($this->imageFile instanceof UploadedFile) 
        */

      //  if(null != $entity->getImageFile()){

            if($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }

}
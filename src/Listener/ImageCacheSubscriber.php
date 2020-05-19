<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
//use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;



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
 
    /*    if (!$entity instanceof Property) {
            return;
        }*/
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    /**
     * @param PreUpdateEventArgs $args
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
      
     /*     if(!$entity instanceof Property){
            return;
        }*/

        /*  $this->imageFile = $imageFile;

        if (null !== $imageFile)
          =
        if ($this->imageFile instanceof UploadedFile) 

        */

        if(null != $entity->getImageFile()){
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }

    //  if($entity->getImageFile() instanceof UploadedFile){

}
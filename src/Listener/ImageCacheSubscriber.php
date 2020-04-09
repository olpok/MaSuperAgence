<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
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
        if(!$entity instanceof Property){
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
        if(!$entity instanceof Property){
            return;
        }
        if($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }



}
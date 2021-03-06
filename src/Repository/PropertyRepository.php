<?php

namespace App\Repository;

use App\Entity\Picture;
use App\Entity\Property;
use App\Entity\PropertySearch;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Property::class);
        $this->paginator = $paginator;
    }

    /**
     * return PaginationInterface
     */
    public function paginateAllVisible(PropertySearch $search, int $page): PaginationInterface
    {
       $query= $this->findVisibleQuery();

        if($search->getMaxPrice()){
            $query=$query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if($search->getMinSurface()){
            $query=$query
                ->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }

        if($search->getPreferences()->count() > 0){ 
            $k = 0;
            foreach ($search->getPreferences() as $preference) {
                $k++;
                $query=$query
                    ->andWhere(":preference$k MEMBER of p.preferences")
                    ->setParameter("preference$k", $preference);
            }
        }

        if ($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query= $query
                ->select('p')
                ->andWhere('(6353 * 2 * ASIN(SQRT(POWER(SIN((p.lat - abs(:lat)) * pi()/180 / 2), 2) + COS(p.lat * pi()/180 ) * COS(abs(:lat) * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) )) ) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance()) ;
                    
        }

        $properties = $this-> paginator->paginate(
            $query->getQuery(),
            $page,
            12
            );
         $this->hydratePicture($properties);

         return $properties;

        
    }

    /**
     * return Property[]
     */
    public function findLatest(): array
    {
      $properties = $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult() ;

            $this->hydratePicture($properties);

            return $properties;
    }


    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('p')
            ->Where('p.sold = false');

    }

    private function hydratePicture($properties)
    {
        if(method_exists($properties, 'getItems')){
            $properties = $properties->getitems();
        }
        $pictures=$this->getEntityManager()->getRepository(Picture::class)->findForProperties($properties);
        foreach($properties as $property)
         {
            /** @var Property $property */
             if ($pictures->containsKey($property->getId()))
             {
                 $property->setPicture($pictures->get($property->getId()));
             }
         }
         return $properties ;
    }

}

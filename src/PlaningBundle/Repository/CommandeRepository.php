<?php

namespace PlaningBundle\Repository;

/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeRepository extends \Doctrine\ORM\EntityRepository
{
   public function  findref($id){

       return $this->createQueryBuilder('cm')
           ->select(' cm.ref')
           ->where('cm.id = :cle')
           ->setParameter('cle', $id)
           ->getQuery()
           ->getResult();
   }


}

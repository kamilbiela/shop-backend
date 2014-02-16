<?php

namespace Shop\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findCurrentOne($uid)
    {
        return $this->findOneBy(array('uid' => $uid, 'isCurrent' => true));
    }
}

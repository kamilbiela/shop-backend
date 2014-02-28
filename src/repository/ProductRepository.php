<?php

namespace Shop\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Criteria;

class ProductRepository extends EntityRepository
{
    public function findCurrentOne($uid)
    {
        return $this->findOneBy(array('uid' => $uid, 'isCurrent' => true));
    }

    public function findCurrentWithoutId($uid, $id)
    {
        $criteria = Criteria::create()->where(
            Criteria::expr()->andX(
                Criteria::expr()->neq('id', $id),
                Criteria::expr()->eq('uid', $uid),
                Criteria::expr()->eq('isCurrent', true)
            )
        );

        return $this->matching($criteria);
    }
}

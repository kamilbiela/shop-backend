<?php

namespace Shop\Model\Listener;

use Shop\Model\Product;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ProductListener
{
    /**
     * If given new entity has
     *
     * @PostPersist
     *
     * @param Product $product
     * @param LifecycleEventArgs $event
     */
    public function enforceOnlyOneCurrentEntity(Product $product, LifecycleEventArgs $event)
    {
        if (!$product->getIsCurrent()) {
            return;
        }

        $em = $event->getEntityManager();

        // @todo find a better way of doing this
        $query = $em->createQuery('UPDATE Shop\Model\Product p SET p.isCurrent = :isCurrent WHERE p.uid = :uid AND p.id < :id');
        $query->setParameter('uid', $product->getUid());
        $query->setParameter('isCurrent', false);
        $query->setParameter('id', $product->getId());
        $query->getResult();
    }
}
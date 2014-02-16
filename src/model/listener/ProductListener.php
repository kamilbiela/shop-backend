<?php

namespace Shop\Model\Listener;

use Shop\Model\Product;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ProductListener
{
    /**
     * If given new entity has
     *
     * @param Product $product
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Product $product, LifecycleEventArgs $event)
    {
        if (!$event->getEntity()->getIsCurrent()) {
            return;
        }

        $em = $event->getEntityManager();

        // this should always be just one product
        $products = $em->getRepository('Shop\Model\Product')->findBy(array(
            'uid' => $product->getUid(),
            'isCurrent' => true
        ));

        foreach ($products as $product) {
            $product->setIsCurrent(false);
            $em->persist($product);
        }

        $em->flush();
    }
}
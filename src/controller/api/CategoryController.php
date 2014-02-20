<?php

namespace Shop\Controller\Api;

use Doctrine\ORM\EntityManager;
use Shop\Lib\Serializer\CollectionSerializerInterface;
use Shop\Model\Product;
use Shop\Model\ProductLang;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Shop\Lib\Serializer\CollectionSerializerInterface
     */
    protected $serializer;

    public function __construct(EntityManager $em, CollectionSerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    public function
}

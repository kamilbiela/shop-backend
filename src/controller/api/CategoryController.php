<?php

namespace Shop\Controller\Api;

use Doctrine\ORM\EntityManager;
use Shop\Lib\Serializer\CollectionSerializerInterface;
use Shop\Model\Product;
use Shop\Model\ProductLang;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController
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

    public function getOneAction($id)
    {
        /* @var $category \Shop\Model\Category */
        $category = $this->em->getRepository('Shop\Model\Category')->findOneBy(array('id' => $id));

        if (!$category) {
            throw new NotFoundHttpException('Category does not exists');
        }

        return new JsonResponse($category->serializeToArray('user'));
    }

    public function getAction()
    {
        $categories = $this->em->getRepository('Shop\Model\Category')->findAll();

        return new JsonResponse($this->serializer->serialize($categories, 'user'));
    }
}

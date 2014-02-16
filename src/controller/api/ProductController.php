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

    public function __construct(EntityManager $em, CollectionSerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    public function getOneAction($uid)
    {
        /* @var $product \Shop\Model\Product */
        $product = $this->em->getRepository('Shop\Model\Product')->findCurrentOne($uid);

        if (!$product) {
            throw new NotFoundHttpException('Product does not exists');
        }

        return new JsonResponse($product->serializeToArray('user'));
    }

    public function getAction()
    {
        $products = $this->em->getRepository('Shop\Model\Product')->findAll();

        return new JsonResponse($this->serializer->serialize($products, 'user'));
    }

    public function addAction(Request $request)
    {
        $product = new Product();
        $product->setIsCurrent(true);
        $this->em->persist($product);

        $response = $this->addOrUpdate($request, $product);

        $this->em->flush();

        return $response;
    }

    public function updateAction($uid, Request $request)
    {
        $product = $this->em->getRepository('Shop\Model\Product')->findCurrentOne($uid);

        if (!$product) {
            throw new NotFoundHttpException('Product does not exists');
        }

        $productUpdate = clone $product;
        $productUpdate->setIsCurrent(true);
        $this->em->persist($productUpdate);

        $response = $this->addOrUpdate($request, $productUpdate);

        $this->em->flush();

        return $response;
    }

    protected function addOrUpdate(Request $request, Product $product)
    {
        if ($product->getId()) {
            $pData = $this->em->getRepository('Shop\Model\ProductLang')->findOneBy(['productUid' => $product->getUid()]);

            if (!$pData) {
                throw new NotFoundHttpException('Product Data does not exists');
            }
        } else {
            $pData = new ProductLang();
        }

        $pData->setName($request->get('name'));
        $pData->setDescription($request->get('description'));
        $pData->setProductUid($product->getUid());
        $this->em->persist($pData);

        $this->em->flush();

        return new JsonResponse(array('message' => 'ok'));
    }
}
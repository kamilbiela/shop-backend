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

        $this->addOrUpdate($request, $product);

        $this->em->flush();

        return new JsonResponse(array('message' => 'ok'));
    }

    public function deleteAction($uid)
    {
        /* @var $product Product */
        $product = $this->em->getRepository('Shop\Model\Product')->findCurrentOne($uid);

        if (!$product) {
            throw new NotFoundHttpException('Product does not exists');
        }

        //
        // @todo - after there is cart and order functionality, delete all non-related product data.
        //

        $product->setIsCurrent(false);
        $this->em->persist($product);
        $this->em->flush();

        return new JsonResponse(array('message' => 'ok'));
    }

    public function updateAction($uid, Request $request)
    {
        $product = $this->em->getRepository('Shop\Model\Product')->findCurrentOne($uid);

        if (!$product) {
            throw new NotFoundHttpException('Product does not exists');
        }

        $productClone = clone $product;
        $productClone->setIsCurrent(true);

        $this->em->persist($productClone);

        $this->addOrUpdate($request, $productClone);

        $this->em->flush();

        return new JsonResponse(array('message' => 'ok'));
    }

    protected function addOrUpdate(Request $request, Product $product)
    {
        if ($product->getId()) {
            $productLang = $this->em->getRepository('Shop\Model\ProductLang')->findOneBy(['productUid' => $product->getUid()]);

            if (!$productLang) {
                throw new NotFoundHttpException('Product Data does not exists');
            }
        } else {
            $productLang = new ProductLang();
        }

        if ($v = $request->get('price')) {
            $product->setPrice($v);
        }

        if ($v = $request->get('name')) {
            $productLang->setName($v);
        }

        if ($v = $request->get('description')) {
            $productLang->setDescription($v);
        }

        if ($v = $request->get('category_id')) {
            $product->setCategory($this->em->getReference('Shop\Model\Category', $v));
        }

        $productLang->setProductUid($product->getUid());

        $this->em->persist($productLang);
        $this->em->flush();
    }
}
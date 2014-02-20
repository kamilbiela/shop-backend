<?php

namespace Shop\Tests\Functional\Controller\Api;

use Shop\Model\ProductLang;
use Shop\Tests\Functional\ShopWebTestCase;

class ProductControllerTest extends ShopWebTestCase
{
    public function testGetOneResponseShouldContainOneObject()
    {
        $uid = 'uid-1';

        $client = $this->createClient();
        $client->request('GET', "/product/$uid");
        $this->assertTrue($client->getResponse()->isOk());

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($uid, $response['uid'], 'Wrong uid');
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetOneNotFoundResponse()
    {
        $client = $this->createClient();
        $client->request('GET', 'product/1234567890');

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function testCreateNewProduct()
    {
        $rand = md5(rand());
        $name = "new product name $rand";

        $data = [
            'name'        => $name,
            'description' => 'product description',
            'price'       => 123.12,
            'category_id' => $this->getEm()->getRepository('Shop\Model\CategoryLang')->findOneBy(['name' => 'Sub Category 1'])->getCategory()->getId()
        ];

        $client = $this->createClient();
        $client->request('POST', "/product", $data);

        $this->assertTrue($client->getResponse()->isOk());

        /* @var $p ProductLang */
        $productLang = $this->getEm()->getRepository('Shop\Model\ProductLang')->findOneBy(['name' => $name]);
        $this->assertNotNull($productLang, 'ProductLang not inserted into database');

        $product = $this->getEm()->getRepository('Shop\Model\Product')->findOneBy(['uid' => $productLang->getProductUid()]);
        $this->assertNotNull($product, 'Product not inserted into database');
    }

    /**
     * @expectedException Doctrine\DBAL\DBALException
     */
    public function testCreateNewProductShouldFailNoRequiredFields()
    {
        $client = $this->createClient();
        $client->request('POST', "/product", []);
    }

    public function testDeleteProduct()
    {
        $uid = 'uid-history';

        $client = $this->createClient();
        $client->request('DELETE', "/product/$uid");

        $this->assertNull($this->getEm()->getRepository('Shop\Model\Product')->findCurrentOne($uid));
    }

    public function testUpdateProduct()
    {
        $name = "new product name " . md5(rand());
        $uid = 'uid-1';
        $price = 123.123;

        $data = [
            'name'        => $name,
            'description' => 'product description',
            'price'       => $price
        ];

        $client = $this->createClient();
        $client->request('PUT', "/product/$uid", $data);

        $this->assertTrue($client->getResponse()->isOk());

        /* @var $productLang ProductLang */
        $productLang = $this->getEm()->getRepository('Shop\Model\ProductLang')->findOneBy(['productUid' => $uid]);
        $this->assertEquals($name, $productLang->getName(), 'ProductLang name must be updated');

        /* @var $product \Shop\Model\Product */
        $product = $this->getEm()->getRepository('Shop\Model\Product')->findCurrentOne($uid);
        $this->assertEquals($price, $product->getPrice(), 'Product price must be updated');

        $this->assertCount(2, $this->getEm()->getRepository('Shop\Model\Product')->findBy(array('uid' => $uid)));
    }
}
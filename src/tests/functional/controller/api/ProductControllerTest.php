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

    public function testUpdateProductDescription()
    {
        $name = "new product name " . md5(rand());
        $uid = 'uid-1';

        $data = [
            'name'        => $name,
            'description' => 'product description'
        ];

        $client = $this->createClient();
        $client->request('PUT', "/product/$uid", $data);

        $this->assertTrue($client->getResponse()->isOk());

        /* @var $p ProductLang */
        $productLang = $this->getEm()->getRepository('Shop\Model\ProductLang')->findOneBy(['productUid' => $uid]);
        $this->assertEquals($name, $productLang->getName(), 'ProductLang name must be updated');

//        $this->assertEquals(2, $this->getEm()->getRepository('Shop\Model'))

    }
}
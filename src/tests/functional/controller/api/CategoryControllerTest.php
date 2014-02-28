<?php

namespace Shop\Tests\Functional\Controller\Api;

use Shop\Model\ProductLang;
use Shop\Tests\Functional\ShopWebTestCase;

class CategoryControllerTest extends ShopWebTestCase
{
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
    }
}
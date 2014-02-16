<?php

namespace Shop\Fixture;

use Shop\Model\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Shop\Model\ProductLang;

class LoadProductFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // generate few products
        for ($i=0; $i < 10; $i++) {
            $uid = null;
            if ($i < 5) {
                $uid = "uid-$i";
            }
            $product = $this->generateProduct($uid);
            $manager->persist($product);

            $productLang = $this->generateProductLang($product);
            $manager->persist($productLang);
        }
//
//        // generate one peoduct with many versions
//        $date = new \DateTime('2014-01-01 00:00:01');
//        $product = $this->generateProduct('uid-history');
//        $manager->persist($product, $date);
//        $productLang = $this->generateProductLang($product);
//        $manager->persist($productLang);
//
//        for ($i=0; $i < 5; $i++)
//        {
//            $date->add(new \DateInterval('PT1H'));
//            $manager->persist($this->generateProduct($product->getUid(), clone $date));
//        }
//
//        $manager->flush();
    }

    /**
     * @param string $uid
     * @param \DateTime $date
     * @return Product
     */
    protected function generateProduct($uid = null, $date = null)
    {
        if ($date === null) {
            $date = new \DateTime('2014-01-01 00:00:01');
        }

        $product = new Product();
        $product->setUid($uid);

        $product->setVersion($date);
        $product->setPrice(100);

        return $product;
    }

    /**
     * @param Product $product
     * @return ProductLang
     */
    protected function generateProductLang(Product $product)
    {
        $data = new ProductLang();
        $data->setName('product name');
        $data->setDescription('description');
        $data->setProductUid($product->getUid());

        return $data;
    }
}
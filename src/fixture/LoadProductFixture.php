<?php

namespace Shop\Fixture;

use Shop\Model\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Shop\Model\ProductLang;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadProductFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array('Shop\Fixture\LoadCategoryFixture');
    }

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

        // generate one product with many versions
        $date = new \DateTime('2014-01-01 00:00:01');
        $product = $this->generateProduct('uid-history');
        $manager->persist($product, $date);

        $manager->persist($this->generateProductLang($product));
        $manager->flush();
        for ($i=0; $i < 5; $i++)
        {
            $date->add(new \DateInterval('PT1H'));
            $manager->persist($this->generateProduct($product->getUid(), clone $date));
            $manager->flush();
        }

        $manager->flush();
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
        $product->setIsCurrent(true);

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
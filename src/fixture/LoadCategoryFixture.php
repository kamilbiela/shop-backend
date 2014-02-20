<?php

namespace Shop\Fixture;

use Shop\Model\Category;
use Shop\Model\CategoryLang;
use Shop\Model\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Shop\Model\ProductLang;

class LoadCategoryFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categoryLang = new CategoryLang();
        $categoryLang->setName('Root Category');
        $manager->persist($categoryLang);

        $rootCategory = new Category();
        $rootCategory->getCategoryLangs()->add($categoryLang);
        $categoryLang->setCategory($rootCategory);
        $manager->persist($rootCategory);

        for ($i=0; $i < 5; $i++)
        {
            $categoryLang = new CategoryLang();
            $categoryLang->setName("Sub Category $i");
            $manager->persist($categoryLang);

            $category = new Category();
            $category->setParent($rootCategory);
            $category->getCategoryLangs()->add($categoryLang);

            $manager->persist($category);

            $categoryLang->setCategory($category);
        }

        $manager->flush();
    }
}
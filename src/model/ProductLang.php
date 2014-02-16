<?php

namespace Shop\Model;

use Shop\Lib\Serializer\ArraySerializableInterface;

/**
 * @Entity(repositoryClass="Shop\Repository\ProductLangRepository")
 * @HasLifecycleCallbacks
 */
class ProductLang implements ArraySerializableInterface
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     * @var integer
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $productUid;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string")
     * @var string
     */

    protected $description;

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $productUid
     */
    public function setProductUid($productUid)
    {
        $this->productUid = $productUid;
    }

    /**
     * @return string
     */
    public function getProductUid()
    {
        return $this->productUid;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function serializeToArray($group) {
        return array(
            'name' => $this->getName(),
            'description' => $this->getDescription()
        );
    }
}
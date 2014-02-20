<?php

namespace Shop\Model;

use Doctrine\Common\Collections\ArrayCollection;
use \Shop\Lib\Serializer\ArraySerializableInterface;


/**
 * @Entity
  */
class Category implements ArraySerializableInterface
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", nullable=false)
     * @var integer
     */
    protected $id = null;

    /**
     * @ManyToOne(targetEntity="Shop\Model\Category", inversedBy="children")
     **/
    protected $parent;

    /**
     * @OneToMany(targetEntity="Shop\Model\Category", mappedBy="parent")
     **/
    protected $children;

    /**
     * @OneToMany(targetEntity="Product", mappedBy="category")
     **/
    protected $products;

    /**
     * @OneToMany(targetEntity="CategoryLang", mappedBy="category")
     **/
    private $categoryLangs;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->categoryLangs = new ArrayCollection();
    }

    /**
     * @param string $serializationGroup
     * @return string json
     */
    public function serializeToArray($serializationGroup)
    {
        // TODO: Implement serializeToArray() method.
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ArrayCollection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $categoryLangs
     */
    public function setCategoryLangs($categoryLangs)
    {
        $this->categoryLangs = $categoryLangs;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategoryLangs()
    {
        return $this->categoryLangs;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
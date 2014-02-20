<?php

namespace Shop\Model;

use Shop\Lib\Serializer\ArraySerializableInterface;

/**
 * @Entity
 */
class CategoryLang implements ArraySerializableInterface
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", nullable=false)
     * @var integer
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="\Shop\Model\Category", inversedBy="categoryLangs")
     * @JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    protected $category;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $locale = 'en';

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param string $serializationGroup
     * @return string json
     */
    public function serializeToArray($serializationGroup)
    {
        // TODO: Implement serializeToArray() method.
    }
}
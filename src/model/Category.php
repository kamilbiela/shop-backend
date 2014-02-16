<?php

namespace Shop\Model;

use Shop\Lib\Serializer\ArraySerializableInterface;

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
    protected $id;

    /**
     * @OneToOne(targetEntity="Shop\Model\Category")
     * @JoinColumn(name="mentor_id", referencedColumnName="id")
     **/
    protected $parent;


    /**
     * @param string $serializationGroup
     * @return string json
     */
    public function serializeToArray($serializationGroup)
    {
        // TODO: Implement serializeToArray() method.
    }
}
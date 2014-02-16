<?php

namespace Shop\Model;

use Shop\Lib\Serializer\ArraySerializableInterface;

/**
 * @Entity(repositoryClass="Shop\Repository\ProductRepository")
 * @Table(uniqueConstraints={@UniqueConstraint(name="uid_version_idx", columns={"uid", "version"})}, indexes={@Index(name="is_current_idx", columns={"isCurrent"})})
 * @EntityListeners({"Shop\Model\Listener\ProductListener"})
  * @HasLifecycleCallbacks
 */
class Product implements ArraySerializableInterface
{
    public function __clone()
    {
        $this->version = null;
    }

    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", nullable=false)
     * @var integer
     */
    protected $id = null;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $uid = null;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $version = null;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $isCurrent = true;

    /**
     * @Column(type="decimal", precision=10, scale=3)
     * @var float
     */
    protected $price = 0;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $isCurrent
     */
    public function setIsCurrent($isCurrent)
    {
        $this->isCurrent = $isCurrent;
    }

    /**
     * @return boolean
     */
    public function getIsCurrent()
    {
        return $this->isCurrent;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param \DateTime $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return \DateTime
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }


    public function serializeToArray($group)
    {
        return array(
            'id'  => $this->getId(),
            'uid' => $this->getUid(),
            'version' => $this->getVersion(),
            'price' => $this->getPrice()
        );
    }

    /**
     * @PrePersist
     */
    public function generateUid()
    {
        if ($this->uid) {
            return;
        }

        $this->uid = uniqid('', true);
    }

    /**
     * @PrePersist
     */
    public function generateVersion()
    {
        if ($this->version) {
            return;
        }

        $this->version = new \DateTime();
    }
}
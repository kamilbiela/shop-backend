<?php

namespace Shop\Lib\Serializer;

interface CollectionSerializerInterface
{
    /**
     * @param Shop\Lib\Serializer\ArraySerializableInterface[] $collection
     * @param string $group
     * @return array
     */
    public function serialize($collection, $group);
}
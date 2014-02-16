<?php

namespace Shop\Lib\Serializer;
use Shop\Lib\Serializer\CollectionSerializerInterface;

class CollectionSerializer implements CollectionSerializerInterface
{
    /**
     * @param ArraySerializableInterface[] $collection
     * @return array
     */
    public function serialize($collection, $group)
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = $item->serializeToArray($group);
        }

        return $result;
    }
}
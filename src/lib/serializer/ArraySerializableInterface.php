<?php

namespace Shop\Lib\Serializer;

interface ArraySerializableInterface
{
    /**
     * @param string $serializationGroup
     * @return string json
     */
    public function serializeToArray($serializationGroup);
}
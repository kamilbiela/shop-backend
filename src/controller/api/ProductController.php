<?php

namespace Shop\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController
{
    public function __construct() {
    }

    public function getOneAction($id) {
        return new JsonResponse(array('test' => 'test', 'id' => $id));
    }
}
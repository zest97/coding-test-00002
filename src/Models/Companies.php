<?php

namespace App\Models;

use App\API\APIRequestInterface;

class Companies
{
    public $data = [];

    public function __construct(APIRequestInterface $httpClient)
    {
        $this->data = $httpClient->fetch();
    }

    public static function init(...$params)
    {
        return new static(...$params);
    }
}

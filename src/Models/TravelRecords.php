<?php

namespace App\Models;

use App\API\APIRequestInterface;

class TravelRecords
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

    public function getTotalCostBy($company)
    {
        $prices = array_map(function($travel) use ($company) {
            if ($company['id'] == $travel['companyId']) {
                return (int)$travel['price'];
            }
            return 0;
        }, $this->data);
        return array_sum($prices);
    }
}

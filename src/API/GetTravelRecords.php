<?php

namespace App\API;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetTravelRecords extends BaseHttpClient implements APIRequestInterface
{
    public function fetch()
    {
        try {
            $travellingRecords = $this->getClient()->request('GET', 'travels');
            return $travellingRecords->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
        return [];
    }
}

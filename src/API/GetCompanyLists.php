<?php

namespace App\API;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetCompanyLists extends BaseHttpClient implements APIRequestInterface
{
    public function fetch()
    {
        try {
            $companies = $this->getClient()->request('GET', 'companies');
            return $companies->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
        return [];
    }
}

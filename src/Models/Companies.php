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

    public function getListOfParentByCompany($company, $companiesToFilterParent)
    {
        $searchList = array($company['id']);
        foreach ($companiesToFilterParent as $companyToSearchParent) {
            if (in_array($companyToSearchParent['parentId'], $searchList)) {
                array_push($searchList, $companyToSearchParent['id']);
            }
        }
        return $searchList;
    }

    public function getChildrenCompany($parentIdList, $companiesToFilter)
    {
        return array_filter($companiesToFilter, function ($company) use ($parentIdList) {
            return in_array($company['parentId'], $parentIdList);
        });
    }

    public function getExceptChildrenCompany($parentIdList, $companiesToFilter)
    {
        return array_filter($companiesToFilter, function ($company) use ($parentIdList) {
            return !in_array($company['parentId'], $parentIdList);
        });
    }
}

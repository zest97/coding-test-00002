<?php

namespace App;

use App\Models\Companies;
use App\Models\TravelRecords;

class TestScript
{
    protected $travelRecords;
    protected $companies;

    public function __construct(Companies $companies, TravelRecords $travelRecords)
    {
        $this->companies = $companies;
        $this->travelRecords = $travelRecords;
    }

    public function execute()
    {
        $result = $this->transformCompanies($this->companies->data);

        echo json_encode($result) . "\n";
    }

    public function transformCompanies($companies)
    {
        if (empty($companies)) {
            return [];
        } else {
            if (count($companies) == 1) {
                return $this->transformCompany(array_values($companies)[0]);
            } else {
                $company = array_values($companies)[0];
                $restOfCompanies = array_slice($companies, 1);

                $searchList = $this->companies->getListOfParentByCompany($company, $restOfCompanies);

                $exceptChildren = $this->companies->getExceptChildrenCompany($searchList, $restOfCompanies);

                if (count($exceptChildren)) {
                    $response = array($this->transformCompany($company));

                    $companiesExceptChildren = $this->transformCompanies($exceptChildren);

                    // flatten array from recursive call
                    if (array_key_exists('id', $companiesExceptChildren)) {
                        array_push($response, $companiesExceptChildren);
                    } else {
                        foreach ($companiesExceptChildren as $companyToResponse) {
                            array_push($response, $companyToResponse);
                        }
                    }

                    return $response;
                } else {
                    return $this->transformCompany($company);
                }
            }
        }
    }

    public function transformCompany($company)
    {
        $searchList = $this->companies->getListOfParentByCompany($company, $this->companies->data);

        $children = $this->companies->getChildrenCompany($searchList, $this->companies->data);

        $childrenCosts = array_sum(array_map(function ($child) {
            return $this->travelRecords->getTotalCostBy($child);
        }, $children));

        $companyCost = $this->travelRecords->getTotalCostBy($company);

        $totalCosts = $childrenCosts + $companyCost;

        return [
            'id' => $company['id'],
            'name' => $company['name'],
            'cost' => $totalCosts,
            'children' => $this->transformCompanies($children)
        ];
    }
}

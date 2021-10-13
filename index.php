<?php

use App\TestScript;
use App\API\GetCompanyLists;
use App\API\GetTravelRecords;
use App\Models\Companies;
use App\Models\TravelRecords;

require __DIR__ . '/vendor/autoload.php';

// Restructure for the test cases
$start = microtime(true);

$companies = Companies::init(new GetCompanyLists);
$travelRecords = TravelRecords::init(new GetTravelRecords);

(new TestScript($companies, $travelRecords))->execute();

echo 'Total time: ' . (microtime(true) - $start) . "\n";

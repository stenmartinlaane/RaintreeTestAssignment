<?php

use App\DAL\DbProvider;
use Base\BaseContractsDAL\IDbProvider;

function displayStatistics(?IDbProvider $dbProvider = null): void {
    global $container;
    $dbProvider = $dbProvider ?? $container->make(IDbProvider::class);
    $result = makeDictionary($dbProvider);
    $charCounts = $result['charCounts'];
    $totalCharCount = $result['totalCharCount'];

    $chars = array_keys($charCounts);
    sort($chars);

    foreach ($chars as $char) {
        $count = $charCounts[$char];
        $percentage = ($count / $totalCharCount) * 100;
        printf("%s\t%d\t%.2f%%\n", strtoupper($char), $count, $percentage);
    }
}

function makeDictionary(IDbProvider $dbProvider) : array
{
    $sql = "SELECT patient.first, patient.last
            FROM patient;
            ";

    $result = $dbProvider->executeQuery($sql);
    $charCounts = array();
    $totalCharCount = 0;

    while($row = $result->fetch_assoc()) {
        $charsInName =  join("", $row);
        $characters = str_split($charsInName);
        foreach ($characters as $char) {
            $char = strtolower($char);
            if (ctype_alpha($char)) {
                $totalCharCount++;
                if (isset($charCounts[$char])) {
                    $charCounts[$char]++;
                } else {
                    $charCounts[$char] = 1;
                }
            }
        }
    }

    return [
        'charCounts' => $charCounts,
        'totalCharCount' => $totalCharCount
    ];
}
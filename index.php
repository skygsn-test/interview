<?php

if ($csvFile = fopen('contacts.csv', 'r')) {
    $countryCodeCol = 0;
    $i = 0;

    while (($csvData = fgetcsv($csvFile, 0, ';')) !== false) {
        if ($i == 0) {
            $countryCodeCol = array_search('Страна', $csvData);
        } else {
            if ($csvData[$countryCodeCol] == 'RU') {
                echo implode(', ', $csvData) . "\n";
            }
        }

        $i++;
    }
} else {
    echo 'Файл не найден';
}
<?php

// Считывание CSV файла в массив и вывод строк со страной = RU

//if ($csvFile = fopen('contacts.csv', 'r')) {
//    $countryCodeCol = 0;
//    $i = 0;
//
//    while (($csvData = fgetcsv($csvFile, 0, ';')) !== false) {
//        if ($i == 0) {
//            $countryCodeCol = array_search('Страна', $csvData);
//        } else {
//            if ($csvData[$countryCodeCol] == 'RU') {
//                echo implode(', ', $csvData) . "\n";
//            }
//        }
//
//        $i++;
//    }
//} else {
//    echo 'Файл не найден';
//}

// Сохранение данных в MySQL и вывод записей с Подписка = "Подписался"

try {
    $pdo = new PDO("mysql:host=192.168.33.22;dbname=interview;charset=utf8", 'root', '123');

    if ($csvFile = fopen('contacts.csv', 'r')) {
        $i = 0;

        while (($csvData = fgetcsv($csvFile, 0, ';')) !== false) {
            if ($i > 0) {
                $dateCreated = DateTime::createFromFormat('n/j/y H:i', $csvData[3]);
                $dateEdit = DateTime::createFromFormat('n/j/y H:i', $csvData[5]);
                $query = "INSERT INTO contacts VALUES (null,'" . $csvData[0] ."','" . $csvData[1] ."','" . $csvData[2] ."','" . $dateCreated->format('Y-m-d H:i:s') ."','" . $csvData[4] ."','" . $dateEdit->format('Y-m-d H:i:s') ."','" . $csvData[6] ."','" . $csvData[7] ."','" . $csvData[8] ."','" . $csvData[9] ."','" . $csvData[10] ."','" . $csvData[11] ."','" . $csvData[12] ."')";
                $pdo->exec($query);
            }

            $i++;
        }
    } else {
        echo 'Файл не найден';
    }

    $query = $pdo->query("SELECT * FROM contacts WHERE subscription = 'Подписался'");
    while ($row = $query->fetch()) {
        $row = array_unique($row);
        echo implode(', ', $row) . "\n";
    }
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}


// Импорт данных из полученного массива в Битрикс
//if ($csvFile = fopen('contacts.csv', 'r')) {
//    $countryCodeCol = 0;
//    $i = 0;
//
//    while (($csvData = fgetcsv($csvFile, 0, ';')) !== false) {
//        if ($i > 0) {
//            $el = new CIBlockElement;
//
//            $PROP = array();
//            $PROP[FULLNAME] = $csvData[1];
//            $PROP[RESPONSIBLE] = $csvData[2];
//
//            $arLoadProductArray = array(
//                "MODIFIED_BY" => $USER->GetID(),
//                "IBLOCK_SECTION_ID" => false,
//                "IBLOCK_ID" => 12,
//                "PROPERTY_VALUES" => $PROP,
//                "NAME" => "Контакт " . $csvData[1],
//                "CODE" => "contact-" . $i,
//                "ACTIVE" => "Y",
//            );
//
//            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
//                echo "Запись создана с ID: ".$PRODUCT_ID;
//            } else {
//                echo "Ошибка при создании: ".$el->LAST_ERROR;
//            }
//        }
//
//        $i++;
//    }
//} else {
//    echo 'Файл не найден';
//}

// Импорт данных в AmoCRM
// Перед выполнением необходимо запустить authInAmoCrm для аутентификации в системе
//try {
//    $pdo = new PDO("mysql:host=192.168.33.22;dbname=interview;charset=utf8", 'root', '123');
//
//    $contactsToApi = [];
//    $query = $pdo->query("SELECT * FROM contacts");
//    while ($row = $query->fetch()) {
//        $dateCreated = DateTime::createFromFormat('d-m-Y H:i:s', $row[4]);
//        $dateUEdited = DateTime::createFromFormat('d-m-Y H:i:s', $row[6]);
//        $contactsToApi[] = [
//            'name' => $row[2],
//            'date_create' => $dateCreated->getTimestamp(),
//            'last_modified' => $dateUEdited->getTimestamp()
//        ];
//        echo implode(', ', $row) . "\n";
//    }
//
//    $link = 'https://new55aab3c4464c6.amocrm.ru/private/api/v2/json/contacts/set';
//
//    $postData = [
//        'request' => [
//            'contacts' => [
//                'add' => $contactsToApi
//            ]
//        ]
//    ];
//
//    $curl = curl_init();
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
//    curl_setopt($curl, CURLOPT_URL, $link);
//    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//    curl_setopt($curl, CURLOPT_HEADER, false);
//    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
//    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
//    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
//    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
//    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
//
//    $out = curl_exec($curl);
//    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//    curl_close($curl);
//
//    $code = (int)$code;
//    $errors = [
//        301 => 'Moved permanently',
//        400 => 'Bad request',
//        401 => 'Unauthorized',
//        403 => 'Forbidden',
//        404 => 'Not found',
//        500 => 'Internal server error',
//        502 => 'Bad gateway',
//        503 => 'Service unavailable'
//    ];
//
//    try {
//        if ($code != 200 && $code != 204)
//            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
//    } catch (Exception $E) {
//        die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
//    }
//
//    $Response = json_decode($out, true);
//    $Response = $Response['response'];
//
//    var_dump($Response);
//} catch (PDOException $e) {
//    die('Подключение не удалось: ' . $e->getMessage());
//}
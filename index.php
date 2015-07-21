<?php

// Считывание CSV файла в массив и вывод строк со страной = RU
//
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

//try {
//    $pdo = new PDO("mysql:host=192.168.33.22;dbname=interview;charset=utf8", 'root', '123');
//
//    if ($csvFile = fopen('contacts.csv', 'r')) {
//        $i = 0;
//
//        while (($csvData = fgetcsv($csvFile, 0, ';')) !== false) {
//            if ($i > 0) {
//                $query = "INSERT INTO contacts VALUES (null,'" . $csvData[0] ."','" . $csvData[1] ."','" . $csvData[2] ."','" . $csvData[3] ."','" . $csvData[4] ."','" . $csvData[5] ."','" . $csvData[6] ."','" . $csvData[7] ."','" . $csvData[8] ."','" . $csvData[9] ."','" . $csvData[10] ."','" . $csvData[11] ."','" . $csvData[12] ."')";
//                $pdo->exec($query);
//            }
//
//            $i++;
//        }
//    } else {
//        echo 'Файл не найден';
//    }
//
//    $query = $pdo->query("SELECT * FROM contacts WHERE subscription = 'Подписался'");
//    while ($row = $query->fetch()) {
//        $row = array_unique($row);
//        echo implode(', ', $row) . "\n";
//    }
//} catch (PDOException $e) {
//    die('Подключение не удалось: ' . $e->getMessage());
//}


// Импорт данных из полученного массива в Битрикс
if ($csvFile = fopen('contacts.csv', 'r')) {
    $countryCodeCol = 0;
    $i = 0;

    while (($csvData = fgetcsv($csvFile, 0, ';')) !== false) {
        if ($i > 0) {
            $el = new CIBlockElement;

            $PROP = array();
            $PROP[FULLNAME] = $csvData[1];
            $PROP[RESPONSIBLE] = $csvData[2];

            $arLoadProductArray = array(
                "MODIFIED_BY" => $USER->GetID(),
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID" => 12,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => "Контакт " . $csvData[1],
                "CODE" => "contact-" . $i,
                "ACTIVE" => "Y",
            );

            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                echo "Запись создана с ID: ".$PRODUCT_ID;
            } else {
                echo "Ошибка при создании: ".$el->LAST_ERROR;
            }
        }

        $i++;
    }
} else {
    echo 'Файл не найден';
}
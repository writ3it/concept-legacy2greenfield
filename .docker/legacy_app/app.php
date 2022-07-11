#!/usr/bin/env php
<?php

function main(){
    $pdo = new PDO('mysql:host=legacy_database;dbname=legacy_db', 'legacy_usr', 'legacy_pwd');

    $recordsToChange = random_int(10,200);

    $stmt  = $pdo->query("SELECT emp_no FROM employees ORDER BY rand() LIMIT {$recordsToChange}");
    $idSet = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $newValue = substr(sha1(random_int(0, 999999999)), 0, 15);

    $pdo->exec("UPDATE employees SET last_name = '{$newValue}' WHERE emp_no IN (".implode(',', $idSet).")");

    echo "Updated {$recordsToChange} records. Ids: ".implode(',', $idSet)."\n";
}

while (true) {
    main();
    sleep(60);
}
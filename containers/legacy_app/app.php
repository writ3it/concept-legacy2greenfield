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

    $randomKeys = array_rand($idSet, 3);
    $id =  $idSet[$randomKeys[0]];

    $pdo->exec("DELETE FROM employees WHERE emp_no = ".sprintf("%d",$id));
    echo "#{$id} record removed.\n";

    $query = $pdo->prepare("INSERT INTO employees (`birth_date`,`first_name`,`last_name`,`gender`,`hire_date`) VALUES (?,?,?,?,?)");
    
    $value = date('Y-m-d',mt_rand(strtotime('2001-01-01 00:00'), strtotime('2020-01-01 00:00')));
    $query->bindParam(1, $value, PDO::PARAM_STR);
    $value = substr(sha1(rand()),0, 6);
    $query->bindParam(2, $value, PDO::PARAM_STR); 
    $value = substr(sha1(rand()),0, 10);
    $query->bindParam(3, $value, PDO::PARAM_STR);
    $value = rand()%2 ==0 ? 'M':'F';
    $query->bindParam(4, $value, PDO::PARAM_STR);
    $value = date('Y-m-d',mt_rand(strtotime('2022-01-01 00:00'), strtotime('2030-01-01 00:00')));
    $query->bindParam(5, $value, PDO::PARAM_STR);
    $query->execute();

    $id = $pdo->lastInsertId();
    echo "#{$id} record inserted.\n";

}

while (true) {
    main();
    sleep(5);
}
<?php
header('Acces-Control-Allow-Origin:*');
header('Content-Type: application/json');

$db = New PDO('mysql:host=localhost;dbname=todo;charset=utf8','root','');
$sql = "select * from task";
$query = $db->query($sql);
$results = $query->fetchAll(PDO::FETCH_ASSOC);
header('HTTP/1.1. 200 OK');
print json_encode($results);
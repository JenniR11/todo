<?php
header('Access-Control-Allow-Origin' .$_SERVER[HTTP_ORIGIN]);
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Method: GET, POST, PUT; DELETE;OPTIONS');
header('Access-Control-Allow-Headers:Accept, Content-Type','Access-Control-Allow-Header');
header('Access-Control-Max-Age: 3600');
header('Content-Type: application/json');

if ($_SERVER['REQUEST']==="OPTIONS") {
    return 0;
}
$input = json_decode(file_get_contents('php://input'));
$description = filter_var($input->description, FILTER_SANITIZE_STRING);

try {
    $db = new PDO('mysql:host=localhost;dbname=todo;charset=utf8', 'root', 'root');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXEPTION);

    $query = $db->prepare('insert into task(description) values (:description)');
    $query->bindValue(':description', $description, PDO::PARAM_STR);
    $query->execute();
    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(),'description' => $description);
    print json_encode($data);

} catch (PDODExeption $pdoex) {
    header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $poex->getMessage());
    print json_encode($error);
}
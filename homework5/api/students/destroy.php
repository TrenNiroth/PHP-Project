<?php
require_once ('./../../bootstrap.php');


$db = new Database();
$id = intval($_GET['id']);
$db->execute('delete from students where id = :id',
['id' => $id]);
echo json_encode([
    "result" => true,
    "message" => "student deleted successfully"
]);
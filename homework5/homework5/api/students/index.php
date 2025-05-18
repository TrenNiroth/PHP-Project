<?php
require_once ('./../../bootstrap.php');

$db = new Database();
$sql = "SELECT id, first_name, last_name, gender, dob, register_at FROM students";
$params = [];

if (isset($_GET['search'])) {
    $search = trim(strval($_GET['search']));
    $sql .= " where first_name like :first or last_name like :last";
    $params['first'] = '%' . $search . '%';
    $params['last'] = '%' . $search . '%';
}

$students = $db->executeAssoc($sql, $params);

echo json_encode([
    'results' => true,
    'message' => 'Successfully get all students.',
    'data' => $students
]);

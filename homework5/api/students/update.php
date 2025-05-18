<?php
require_once('./../../bootstrap.php');

if (!isset($_POST['first_name'], $_POST['last_name'], $_POST['gender'], $_POST['dob'], $_POST['register_at'])) {
    echo json_encode([
        'results' => false,
        'message' => 'Missing required fields.',
        'data' => []
    ]);
    exit;
}

$db = new Database();

$firstName = trim(strval($_POST['first_name']));
$lastName = trim(strval($_POST['last_name']));
$gender = intval($_POST['gender']);
$dob = $_POST['dob'];
$registerAt = $_POST['register_at'];
$id = intval($_GET['id']);

if (!in_array($gender, [0, 1, 2])) {
    echo json_encode([
        'results' => false,
        'message' => 'Geder must be 0 for Unknown, 1 for Male and 2 for Female.',
        'data' => []
    ]);
    exit();
}

function isDateTime($dateTime)
{
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
    return $d && $d->format('Y-m-d H:i:s') === $dateTime;
}

function isDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

if (!isDate($dob)) {
    echo json_encode([
        'results' => false,
        'message' => 'dob must be YYYY-MM-DD.',
        'data' => []
    ]);
    exit;
}

if (!isDateTime($registerAt)) {
    echo json_encode([
        'results' => false,
        'message' => 'Register_at must be YYYY-MM-DD HH:MM:SS.',
        'data' => []
    ]);
    exit;
}


$db->execute(
    "
    update students set first_name = :fname, last_name = :lname, gender = :g, dob = :dob, register_at = :rat where id = :id",
    [
        ':fname' => $firstName,
        ':lname' => $lastName,
        'g' => $gender,
        'dob' => $dob,
        'rat' => $registerAt,
        ':id' => $id
    ]
);

echo json_encode([
    'result' => true,
    'message' => 'success updated',
    'data' => [
        'id' => $id,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'gender' => $gender,
        'dob' => $dob,
        'register_at' => $registerAt,
    ]
]);

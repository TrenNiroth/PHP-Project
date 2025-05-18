<?php
require_once ('./../../bootstrap.php');

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
    'insert into students (first_name, last_name, gender, dob, register_at) value (:fname, :lname, :g, :dob, :rat)',
    [
        'fname' => $firstName,
        'lname' => $lastName,
        'g' => $gender,
        'dob' => $dob,
        'rat' => $registerAt
    ]
);

$id = $db->lastInsertId();

echo json_encode([
    'results' => true,
    'message' => 'Success! Student has been added.',
    'data' => [
        'id' => $id,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'gender' => $gender,
        'dob' => $dob,
        'register_at' => $registerAt
    ]
]);
?>

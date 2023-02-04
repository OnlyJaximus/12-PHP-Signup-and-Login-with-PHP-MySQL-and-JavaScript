<?php

// $mysqli = require_once __DIR__ . "/database.php";

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}


if (strlen($_POST['password']) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST['password'])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST['password'])) {
    die("Password must contain at least one number");
}

if ($_POST['password'] !== $_POST['password_confirmation']) {
    die("Password must match");
}

$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);


// echo "<pre>";
// print_r($_POST);
// echo "<br>";
// var_dump($password_hash); // string(60) "$2y$10$Q61.Gfwh9Y01jy/v5qdte.r3mV7C.az3OF7MKM45uzQ8XXArM/bea"

// Array
// (
//     [name] => Branko 
//     [email] => blesicb@yahoo.com
//     [password] => 12345
//     [password_confirmation] => 12345
// )

$mysqli = require_once __DIR__ . "/database.php";
$sql = "INSERT INTO users_hash (name, email, password_hash) VALUES (?, ?, ?)";



//  mysqli_stmt_init — Initializes a statement and returns an object for use with mysqli_stmt_prepare
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {  // if the prepare method returns false then there is problem with the SQL
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sss",
    $_POST['name'],
    $_POST['email'],
    $password_hash
);

// $stmt->execute(); // returns true if it was successful and false otherwise

if ($stmt->execute()) {
    // echo "Signup successful";
    header("Location: signup-success.html");
    exit();
} else {
    if ($mysqli->errno === 1062) {
        die("email is already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

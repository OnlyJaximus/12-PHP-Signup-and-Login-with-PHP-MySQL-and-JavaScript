<?php

session_start();
// print_r($_SESSION); // Array ( )  Array ( [user_id] => 1 )

if (isset($_SESSION['user_id'])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM users_hash 
            WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css">
    <title>Home</title>
</head>

<body>
    <h1>Login</h1>

    </ /?php if (isset($_SESSION['user_id'])) : ?>
    <?php if (isset($user)) : ?>
        <p>You are logged in.</p>
        <p>Hello <?= htmlspecialchars($user['name']) ?></p>
        <p><a href="logout.php">Logout</a></p>
    <?php else : ?>
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
    <?php endif; ?>


</body>

</html>
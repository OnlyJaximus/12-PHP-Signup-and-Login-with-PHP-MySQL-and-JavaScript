<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf(
        "SELECT * FROM users_hash where email = '%s'",
        $mysqli->real_escape_string($_POST['email'])
    );

    $result = $mysqli->query($sql); // this returns a result object

    $user = $result->fetch_assoc();

    // var_dump($user);
    // exit;
    // array(4) {
    //     ["id"]=>
    //     string(1) "1"
    //     ["name"]=>
    //     string(7) "Branko "
    //     ["email"]=>
    //     string(17) "blesicb@yahoo.com"
    //     ["password_hash"]=>
    //     string(60) "$2y$10$EVZEKwRuySoPHcxB809Jr.RUc6mqqngDaeT4ZkXYdYB/0L7Og9U4G"
    //   }


    if ($user) {
        if (password_verify($_POST['password'], $user['password_hash'])) {
            // die("Login successful");
            session_start();
            session_regenerate_id();
            //  session_regenerate_id() will replace the current session id with a new one, and keep the current session information. 

            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css">
    <title>Signup</title>
</head>

<body>
    <h1>Login</h1>
    <p>Don't have account? <a href="signup.html">Register here</a></p>

    <?php if ($is_invalid) : ?>
        <em>Invalid Login</em>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo  htmlspecialchars($_POST['email'] ?? "") ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button>Log in</button>
    </form>

</body>

</html>
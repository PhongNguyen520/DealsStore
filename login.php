<?php
require_once __DIR__ . "/models/Database.php";
require_once __DIR__ . "/models/User.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::login($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = serialize($user);

        if ($user->role == 'admin') {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        $error = "Incorrect account or password...";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>



    <form action="login.php" method="POST">
        <h2>Login</h2>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Login</button>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
</body>

</html>
<?php
session_start();

include "config/database.php";

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin 
            WHERE username='$username' 
            AND password='$password'";

    $sql = "SELECT * FROM admin WHERE username='$username'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $admin = mysqli_fetch_assoc($result);

    if (password_verify($password, $admin['password'])) {

        $_SESSION['admin'] = $username;

        header("Location: dashboard.php");
        exit();

    } else {

        $error = "Invalid username or password.";

    }

} else {

    $error = "Invalid username or password.";

}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Employee Management System</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="login-page">

    <div class="login-container">

        <h1>Employee Management System</h1>

        <h2>Admin Login</h2>

        <?php
        if ($error != "") {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <form method="POST">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required
            >

            <button type="submit" name="login">
                Login
            </button>

        </form>

    </div>

</div>

</body>

</html>
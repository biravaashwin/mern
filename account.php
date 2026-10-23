<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

$message = "";

if (isset($_POST['change_password'])) {

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {

        $message = "New passwords do not match!";

    } else {

        $username = $_SESSION['admin'];

        $result = mysqli_query(
            $conn,
            "SELECT * FROM admin WHERE username='$username'"
        );

        $admin = mysqli_fetch_assoc($result);

        if ($admin && password_verify($current_password, $admin['password'])) {

            $hashed_password = password_hash(
    $new_password,
    PASSWORD_DEFAULT
);

$sql = "UPDATE admin
        SET password='$hashed_password'
        WHERE username='$username'";

            if (mysqli_query($conn, $sql)) {

                $message = "Password changed successfully!";

            } else {

                $message = "Error changing password.";

            }

        } else {

            $message = "Current password is incorrect.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Account - Employee Management System</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav class="navbar">

    <div class="logo">
        Employee Management System
    </div>

    <div class="nav-links">

        <a href="dashboard.php">Dashboard</a>

        <a href="employees.php">Employees</a>

        <a href="add_employee.php">Add Employee</a>

        <a href="account.php">Account</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="form-container">

    <div class="form-header">

        <h1>Admin Account</h1>

        <p>Manage your account and password</p>

    </div>


    <?php

    if ($message != "") {

        echo "<div class='success'>$message</div>";

    }

    ?>


    <div class="form-group">

        <label>Username</label>

        <input
            type="text"
            value="<?php echo htmlspecialchars($_SESSION['admin']); ?>"
            readonly
        >

    </div>


    <form method="POST">

        <div class="form-group">

            <label>Current Password</label>

            <input
                type="password"
                name="current_password"
                required
            >

        </div>


        <div class="form-group">

            <label>New Password</label>

            <input
                type="password"
                name="new_password"
                required
            >

        </div>


        <div class="form-group">

            <label>Confirm New Password</label>

            <input
                type="password"
                name="confirm_password"
                required
            >

        </div>


        <button
            type="submit"
            name="change_password"
            class="save-button"
        >
            Change Password
        </button>

    </form>

</div>

</body>

</html>
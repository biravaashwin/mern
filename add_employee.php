<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

$message = "";

if (isset($_POST['add'])) {

    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $joining_date = $_POST['joining_date'];
    $salary = $_POST['salary'];
    $address = $_POST['address'];

    $stmt = mysqli_prepare(
    $conn,
    "INSERT INTO employees
    (employee_id, name, email, phone, gender, dob,
     department, designation, joining_date, salary, address)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    $message = "Prepare Error: " . mysqli_error($conn);
} else {

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssss",
        $employee_id,
        $name,
        $email,
        $phone,
        $gender,
        $dob,
        $department,
        $designation,
        $joining_date,
        $salary,
        $address
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Employee added successfully!";
    } else {
        $message = "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Employee - Employee Management System</title>

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

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="form-container">

    <div class="form-header">

        <h1>Add New Employee</h1>

        <p>Enter employee information below</p>

    </div>


    <?php

    if ($message != "") {

        echo "<div class='success'>$message</div>";

    }

    ?>


    <form method="POST" class="employee-form">


        <div class="form-grid">


            <div class="form-group">

                <label>Employee ID</label>

                <input
                    type="text"
                    name="employee_id"
                    placeholder="EMP001"
                    required
                >

            </div>


            <div class="form-group">

                <label>Full Name</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter full name"
                    required
                >

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="example@gmail.com"
                    required
                >

            </div>


            <div class="form-group">

                <label>Phone</label>

                <input
    type="text"
    name="phone"
    placeholder="Enter 10-digit phone number"
    pattern="[0-9]{10}"
    maxlength="10"
>

            </div>


            <div class="form-group">

                <label>Gender</label>

                <select name="gender" required>

                    <option value="">
                        Select Gender
                    </option>

                    <option value="Male">
                        Male
                    </option>

                    <option value="Female">
                        Female
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Date of Birth</label>

                <input
                    type="date"
                    name="dob"
                >

            </div>


            <div class="form-group">

                <label>Department</label>

                <select name="department" required>

                    <option value="">
                        Select Department
                    </option>

                    <option value="IT">
                        IT
                    </option>

                    <option value="HR">
                        HR
                    </option>

                    <option value="Finance">
                        Finance
                    </option>

                    <option value="Marketing">
                        Marketing
                    </option>

                    <option value="Sales">
                        Sales
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Designation</label>

                <input
                    type="text"
                    name="designation"
                    placeholder="Software Developer"
                >

            </div>


            <div class="form-group">

                <label>Joining Date</label>

                <input
                    type="date"
                    name="joining_date"
                >

            </div>


            <div class="form-group">

                <label>Salary</label>

                <input
    type="number"
    name="salary"
    placeholder="30000"
    min="0"
>

            </div>


            <div class="form-group full-width">

                <label>Address</label>

                <textarea
                    name="address"
                    placeholder="Enter employee address"
                ></textarea>

            </div>


        </div>


        <div class="form-actions">

            <a href="employees.php" class="cancel-button">
                Cancel
            </a>

            <button type="submit" name="add" class="save-button">
                Add Employee
            </button>

        </div>


    </form>

</div>

</body>

</html>
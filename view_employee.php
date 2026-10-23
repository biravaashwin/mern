<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

if (!isset($_GET['id'])) {
    header("Location: employees.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM employees WHERE id=$id"
);

$employee = mysqli_fetch_assoc($result);


if (!$employee) {
    die("Employee not found!");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Profile - Employee Management System</title>

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


<div class="profile-container">

    <div class="profile-header">

        <div>

            <h1>Employee Profile</h1>
            

            <p>Complete employee information</p>

        </div>

        <a href="employees.php" class="cancel-button">
            Back to Employees
        </a>

    </div>


    <div class="profile-card">

        <div class="profile-title">

            <div class="profile-avatar">
                <?php echo strtoupper(substr($employee['name'], 0, 1)); ?>
            </div>

            <div>

                <h2>
                    <?php echo htmlspecialchars($employee['name']); ?>
                </h2>

                <p>
                    <?php echo htmlspecialchars($employee['designation']); ?>
                </p>

            </div>

        </div>


        <div class="profile-grid">


            <div class="profile-item">

                <span>Employee ID</span>

                <strong>
                    <?php echo htmlspecialchars($employee['employee_id']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Email</span>

                <strong>
                    <?php echo htmlspecialchars($employee['email']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Phone</span>

                <strong>
                    <?php echo htmlspecialchars($employee['phone']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Gender</span>

                <strong>
                    <?php echo htmlspecialchars($employee['gender']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Date of Birth</span>

                <strong>
                    <?php echo htmlspecialchars($employee['dob']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Department</span>

                <strong>
                    <?php echo htmlspecialchars($employee['department']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Designation</span>

                <strong>
                    <?php echo htmlspecialchars($employee['designation']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Joining Date</span>

                <strong>
                    <?php echo htmlspecialchars($employee['joining_date']); ?>
                </strong>

            </div>


            <div class="profile-item">

                <span>Salary</span>

                <strong>
                    ₹<?php echo htmlspecialchars($employee['salary']); ?>
                </strong>

            </div>


            <div class="profile-item full-profile">

                <span>Address</span>

                <strong>
                    <?php echo htmlspecialchars($employee['address']); ?>
                </strong>

            </div>


        </div>


        <div class="profile-actions">

            <a
                href="edit_employee.php?id=<?php echo $employee['id']; ?>"
                class="edit-button"
            >
                Edit Employee
            </a>

        </div>

    </div>

</div>

</body>

</html>
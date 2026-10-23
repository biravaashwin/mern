<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

/* Total Employees */

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM employees"
);

$row = mysqli_fetch_assoc($result);

$total = $row['total'];


/* IT Employees */

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM employees WHERE department='IT'"
);

$row = mysqli_fetch_assoc($result);

$it = $row['total'];


/* HR Employees */

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM employees WHERE department='HR'"
);

$row = mysqli_fetch_assoc($result);

$hr = $row['total'];


/* Other Departments */

$other = $total - $it - $hr;

?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Employee Management System</title>

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

        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>

    </div>

</nav>


<div class="dashboard-container">


    <div class="welcome">

        <h1>Dashboard</h1>

        <p>
            Welcome back,
            <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong>!
        </p>

    </div>
<h2 style="color:#1e293b; margin-bottom:20px;">
    Employee Summary
</h2>

    <div class="stats-grid">


        <div class="stat-card">

            <h3>Total Employees</h3>

            <div class="stat-number">
                <?php echo $total; ?>
            </div>

            <p>Registered employees</p>

        </div>


        <div class="stat-card">

            <h3>IT Department</h3>

            <div class="stat-number">
                <?php echo $it; ?>
            </div>

            <p>IT employees</p>

        </div>


        <div class="stat-card">

            <h3>HR Department</h3>

            <div class="stat-number">
                <?php echo $hr; ?>
            </div>

            <p>HR employees</p>

        </div>


        <div class="stat-card">

            <h3>Other Departments</h3>

            <div class="stat-number">
                <?php echo $other; ?>
            </div>

            <p>Other employees</p>

        </div>


    </div>


    <div class="dashboard-actions">

        <a href="add_employee.php" class="action-button">
            + Add Employee
        </a>

        <a href="employees.php" class="action-button">
            View Employees
        </a>

    </div>
    <div class="department-section" style="background:white; padding:25px; margin-top:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.08);">

    <h2>Department Overview</h2>

    <div class="department-list">

        <div class="department-row" style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px 18px; margin-bottom:12px; border-radius:8px;">
            <span>IT</span>
            <strong><?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE department='IT'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
            ?> Employees</strong>
        </div>

        <div class="department-row" style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px 18px; margin-bottom:12px; border-radius:8px;">
            <span>HR</span>
            <strong><?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE department='HR'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
            ?> Employees</strong>
        </div>

        <div class="department-row" style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px 18px; margin-bottom:12px; border-radius:8px;">
            <span>Finance</span>
            <strong><?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE department='Finance'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
            ?> Employees</strong>
        </div>

        <div class="department-row" style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px 18px; margin-bottom:12px; border-radius:8px;">
            <span>Marketing</span>
            <strong><?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE department='Marketing'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
            ?> Employees</strong>
        </div>

        <div class="department-row" style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px 18px; margin-bottom:12px; border-radius:8px;">
            <span>Sales</span>
            <strong><?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE department='Sales'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
            ?> Employees</strong>
        </div>

    </div>
    
        </div>


    <div style="background:white; padding:25px; margin-top:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.08);">

        <h2 style="color:#1e293b; margin-bottom:20px;">
    Recently Added Employees
</h2>

        <?php

$recent = mysqli_query(
    $conn,
    "SELECT * FROM employees ORDER BY id DESC LIMIT 5"
);

while ($employee = mysqli_fetch_assoc($recent)) {

?>

    <div style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px 18px; margin-bottom:12px; border-radius:8px;">

        <div>

            <a
    href="view_employee.php?id=<?php echo $employee['id']; ?>"
    style="color:#1e293b; font-weight:bold; text-decoration:none;"
>
    <?php echo htmlspecialchars($employee['name']); ?>
</a>

            <p style="color:#64748b; margin:5px 0 0;">
                <?php echo htmlspecialchars($employee['department']); ?>
                -
                <?php echo htmlspecialchars($employee['designation']); ?>
            </p>

        </div>

        <div>

    <span style="color:#2563eb; font-weight:bold; margin-right:15px;">
        <?php echo htmlspecialchars($employee['employee_id']); ?>
    </span>

    <a
        href="view_employee.php?id=<?php echo $employee['id']; ?>"
        class="view-button"
    >
        View
    </a>

</div>

    </div>

<?php

}

?>

    </div>


</div>

</div>

</div>

<script>
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

</body>

</html>
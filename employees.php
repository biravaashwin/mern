<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$department = "";

if (isset($_GET['department'])) {
    $department = $_GET['department'];
}

$sql = "SELECT * FROM employees
        WHERE (employee_id LIKE '%$search%'
        OR name LIKE '%$search%'
        OR email LIKE '%$search%'
        OR phone LIKE '%$search%'
        OR designation LIKE '%$search%')";

if ($department != "") {
    $sql .= " AND department='$department'";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employees - Employee Management System</title>

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


<div class="employee-container">

    <div class="page-header">

        <div>
    <h1>Employee Records</h1>
    <p>
        Manage all registered employees
        <strong>(<?php echo mysqli_num_rows($result); ?> employees)</strong>
    </p>
</div>
        <a href="add_employee.php" class="action-button">
            + Add Employee
        </a>

    </div>


    <form method="GET" class="search-form">

    <input
        type="text"
        name="search"
        placeholder="Search employees..."
        value="<?php echo htmlspecialchars($search); ?>"
    >

    <select name="department">

        <option value="">All Departments</option>

        <option value="IT">IT</option>

        <option value="HR">HR</option>

        <option value="Finance">Finance</option>

        <option value="Marketing">Marketing</option>

        <option value="Sales">Sales</option>

    </select>

    <button type="submit">
        Search
    </button>

</form>


    <div class="table-container">

        <table class="employee-table">

            <thead>

                <tr>

                    <th>Employee ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Department</th>

                    <th>Designation</th>

                    <th>Salary</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

            ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row['employee_id']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['phone']); ?>
                    </td>

                    <td>
                        <span class="department">
                            <?php echo htmlspecialchars($row['department']); ?>
                        </span>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['designation']); ?>
                    </td>

                    <td>
                        ₹<?php echo htmlspecialchars($row['salary']); ?>
                    </td>

                   <td>

   <a
    href="view_employee.php?id=<?php echo $row['id']; ?>"
    style="display:inline-block; padding:7px 11px; background:#e0e7ff; color:#2563eb; text-decoration:none; border-radius:5px; font-size:13px; margin-right:5px;"
>
    View
</a>

    <a
        href="edit_employee.php?id=<?php echo $row['id']; ?>"
        class="edit-button"
    >
        Edit
    </a>

    <a
        href="delete_employee.php?id=<?php echo $row['id']; ?>"
        class="delete-button"
        onclick="return confirm('Are you sure you want to delete this employee?')"
    >
        Delete
    </a>

</td>

                </tr>

            <?php

                }

            } else {

            ?>

                <tr>

                   <td colspan="8" class="no-data">
    ⚠️ No employees found for the selected search or department.
</td>	
                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>
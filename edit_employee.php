<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM employees WHERE id=$id");

$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    die("Employee not found!");
}

if (isset($_POST['update'])) {

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
    "UPDATE employees SET
        employee_id=?,
        name=?,
        email=?,
        phone=?,
        gender=?,
        dob=?,
        department=?,
        designation=?,
        joining_date=?,
        salary=?,
        address=?
     WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssssi",
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
    $address,
    $id
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: employees.php");
    exit();

} else {

    echo "Error: " . mysqli_stmt_error($stmt);
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Employee - Employee Management System</title>

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

        <h1>Edit Employee</h1>

        <p>Update employee information</p>

    </div>


    <form method="POST" class="employee-form">

        <div class="form-grid">


            <div class="form-group">

                <label>Employee ID</label>

                <input
                    type="text"
                    name="employee_id"
                    value="<?php echo htmlspecialchars($employee['employee_id']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Full Name</label>

                <input
                    type="text"
                    name="name"
                    value="<?php echo htmlspecialchars($employee['name']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($employee['email']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Phone</label>

                <input
                    type="text"
                    name="phone"
                    value="<?php echo htmlspecialchars($employee['phone']); ?>"
                >

            </div>


            <div class="form-group">

                <label>Gender</label>

                <select name="gender">

                    <option value="Male"
                        <?php if ($employee['gender'] == "Male") echo "selected"; ?>>
                        Male
                    </option>

                    <option value="Female"
                        <?php if ($employee['gender'] == "Female") echo "selected"; ?>>
                        Female
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Date of Birth</label>

                <input
                    type="date"
                    name="dob"
                    value="<?php echo $employee['dob']; ?>"
                >

            </div>


            <div class="form-group">

                <label>Department</label>

                <select name="department">

                    <option value="IT"
                        <?php if ($employee['department'] == "IT") echo "selected"; ?>>
                        IT
                    </option>

                    <option value="HR"
                        <?php if ($employee['department'] == "HR") echo "selected"; ?>>
                        HR
                    </option>

                    <option value="Finance"
                        <?php if ($employee['department'] == "Finance") echo "selected"; ?>>
                        Finance
                    </option>

                    <option value="Marketing"
                        <?php if ($employee['department'] == "Marketing") echo "selected"; ?>>
                        Marketing
                    </option>

                    <option value="Sales"
                        <?php if ($employee['department'] == "Sales") echo "selected"; ?>>
                        Sales
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Designation</label>

                <input
                    type="text"
                    name="designation"
                    value="<?php echo htmlspecialchars($employee['designation']); ?>"
                >

            </div>


            <div class="form-group">

                <label>Joining Date</label>

                <input
                    type="date"
                    name="joining_date"
                    value="<?php echo $employee['joining_date']; ?>"
                >

            </div>


            <div class="form-group">

                <label>Salary</label>

                <input
                    type="number"
                    name="salary"
                    value="<?php echo $employee['salary']; ?>"
                >

            </div>


            <div class="form-group full-width">

                <label>Address</label>

                <textarea name="address"><?php echo htmlspecialchars($employee['address']); ?></textarea>

            </div>


        </div>


        <div class="form-actions">

            <a href="employees.php" class="cancel-button">
                Cancel
            </a>

            <button type="submit" name="update" class="save-button">
                Update Employee
            </button>

        </div>

    </form>

</div>

</body>

</html>
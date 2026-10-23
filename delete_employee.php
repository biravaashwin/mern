<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include "config/database.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = mysqli_prepare(
    $conn,
    "DELETE FROM employees WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

    if (mysqli_stmt_execute($stmt)) {

    header("Location: employees.php");
    exit();

} else {

    echo "Error deleting employee: " . mysqli_stmt_error($stmt);

}

} else {

    echo "Employee ID not provided.";

}

?>
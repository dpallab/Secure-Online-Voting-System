<?php
session_start();
include('../admin/inc/config.php');
if ($_SESSION['Key'] != "VotersKey") {
    // echo "<script>
    //     location.assign('logout.php');
    // </script>";
    header('location:../admin/inc/logout.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voters Panel-Online voting system</title>
    <link rel="stylesheet" href="../assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/CSS/style.css">
</head>

<body>

    <!-- Header Start -->
<div class="container-fluid bg-dark text-white py-2">
    <div class="row align-items-center">

        <!-- Logo -->
        <div class="col-2 col-md-1 text-center">
            <img src="../assets/images/image.png" alt="Logo" width="60">
        </div>

        <!-- Title -->
        <div class="col-6 col-md-7">
            <h4 class="mb-0">Online Voting System</h4>
            <small class="text-light">
                Welcome, <strong><?php echo $_SESSION['username']; ?></strong>
            </small>
        </div>

        <!-- Logout button -->
        <div class="col-4 col-md-4 text-right">
            <a href="../admin/logout.php" class="btn btn-sm btn-outline-light mt-1">
                Logout
            </a>
        </div>

    </div>

<!-- Header End -->
</div>
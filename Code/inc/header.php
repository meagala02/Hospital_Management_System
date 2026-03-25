<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$rootUrl = '/MediCarePlus' ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Care Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $rootUrl; ?>/css/style.css?v=0.5">
</head>

<body>

    <div class="header-section">
        <div class="container">
            <div class="header">
                <div class="logo">Medi Care Plus</div>
                <div class="menu">
                    <ul class="text-menu">
                        <li><a href="<?php echo $rootUrl; ?>/index.php">Home</a></li>
                        <li><a href="<?php echo $rootUrl; ?>/services.php">Services</a></li>
                        <li><a href="<?php echo $rootUrl; ?>/doctor.php">Doctors</a></li>
                    </ul>
                    <ul class="btn-menu">


                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin'): ?>
                            <li><a href="<?php echo $rootUrl; ?>/admin/doctor_index.php">Manage Doctors</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/service_index.php">Manage Services</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/feedback_index.php">Manage Feedbacks</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/test_result_create.php">Manage Test Result</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/user_create.php">Manage Users</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/appointment_index.php">All Appointments</a></li>

                        <?php endif; ?>

                         <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'patient'): ?>
                            <li><a href="<?php echo $rootUrl; ?>/admin/test_result_index.php">Test Result</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/appointment_index.php">my Appointments</a></li>


                        <?php endif; ?>

                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'doctor'): ?>
                            
                            <li><a href="<?php echo $rootUrl; ?>/admin/appointment_index.php">my Appointments</a></li>


                        <?php endif; ?>



                        <?php if (isset($_SESSION['user_id'])): ?>

                            
                                                       <li><a href="<?php echo $rootUrl; ?>/admin/manage_profile.php">My Profile</a></li>

                            <li><a href="<?php echo $rootUrl; ?>/admin/logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo $rootUrl; ?>/admin/appointment_create.php">Book Now</a></li>
                            <li><a href="<?php echo $rootUrl; ?>/admin/login.php">Login / Register</a></li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
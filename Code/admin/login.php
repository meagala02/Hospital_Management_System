<?php include('../inc/header.php');
include('../inc/connection.php');
$message = "";
// Login
if (isset($_POST['login'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM USERS WHERE user_name='$user_name' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // password (hashed)
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_role'] = $row['user_role'];

            header("Location: ../admin/appointment_index.php");

            exit;
        } else {
            $message = "Invalid username or password!";
        }
    } else {
        $message = "User not found!";
    }
}

?>
<div class="login-container">
    <h2><i class="fa fa-user"></i> Login</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        <p class="alert-success">Registration successful! Please login.</p>
    <?php } ?>


    <?php if ($message != "") { ?>
        <p class="message"><?= $message ?></p>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <i class="fa fa-user"></i>
            <input type="text" name="user_name" placeholder="Enter Username" required>
        </div>

        <div class="input-box">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Enter Password" required>
        </div>

        <button type="submit" name="login">Login</button>

        <a class="reg-button" href="register.php">Patient Registration</a>

    </form>
</div>
<?php include('../inc/footer.php'); ?>
<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');


if (isset($_POST['create'])) {

    $username = $_POST['username'];
    $plain_password = $_POST['password'];
    $user_role = $_POST['user_role'];

    // Hash password
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT user_id FROM users WHERE user_name='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username already exists! Choose another one.');</script>";
    } else {

        $sql = "INSERT INTO users (user_name, password, user_role)
                VALUES ('$username', '$hashed_password', '$user_role')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: user_index.php?msg=success&username=$username");
            exit;
        } else {
            echo "User Insert Error: " . mysqli_error($conn);
        }
    }
}
?>

<div class="form-container">
    <h2>Create User</h2>

    <form action="" method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>User Role</label>
        <select name="user_role" required>
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select>

        <button type="submit" name="create" class="submit-btn">
            <i class="fa fa-save"></i> Create User
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
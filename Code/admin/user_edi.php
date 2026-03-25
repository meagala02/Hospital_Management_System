<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');

if (!isset($_GET['user_id'])) {
    echo "Invalid Request!";
    exit;
}

$user_id = $_GET['user_id'];

// Fetch user record
$user_sql = "SELECT * FROM users WHERE user_id = $user_id";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    echo "User Not Found!";
    exit;
}


if (isset($_POST['update'])) {

    $username = $_POST['username'];
    $user_role = $_POST['user_role'];

    //update user table 
    $sql_user = "UPDATE users 
                 SET user_name='$username',
                     user_role='$user_role'
                 WHERE user_id=$user_id";

    mysqli_query($conn, $sql_user);

    //update doctor table

    if ($user_role == "doctor") {
        mysqli_query($conn, "UPDATE doctors SET doctor_name='$username' WHERE user_id=$user_id");
    }
    //ipdate patient table

    if ($user_role == "patient") {
        mysqli_query($conn, "UPDATE patients SET user_name='$username' WHERE user_id=$user_id");
    }

    header("Location: user_index.php?msg=updated");
    exit;
}
?>

<div class="form-container">
    <h2>Edit User</h2>

    <form action="" method="POST">

        <label>Username</label>
        <input type="text" name="username" value="<?php echo $user['user_name']; ?>" required>

        <label>User Role</label>
        <select name="user_role" required>
            <option value="admin" <?php echo ($user['user_role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="doctor" <?php echo ($user['user_role'] == 'doctor') ? 'selected' : ''; ?>>Doctor</option>
            <option value="patient" <?php echo ($user['user_role'] == 'patient') ? 'selected' : ''; ?>>Patient</option>
        </select>

        <button type="submit" name="update" class="submit-btn">
            <i class="fa fa-save"></i> Update User
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/session.php');

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
// Fetch user data
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
// UPDATE PROFILE
if (isset($_POST['update'])) {

    $name = $_POST['user_name'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        $password = $user['password'];
    }
    if ($user_role == 'patient') {
        $nic = isset($_POST['nic']) ? $_POST['nic'] : '';
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';

        $sqlUpdate = "
            UPDATE users SET
                user_name='$name',
                password='$password',
                nic='$nic',
                mobile='$mobile',
                gender='$gender',
                address='$address'
            WHERE user_id='$user_id'
        ";
    } else {
        // ADMIN / DOCTOR
        $sqlUpdate = "
            UPDATE users SET
                user_name='$name',
                password='$password'
            WHERE user_id='$user_id'
        ";
    }

    if (mysqli_query($conn, $sqlUpdate)) {
        echo '<div class="form-container"><div class="alert-success">Profile updated successfully!</div></div>';
    } else {
        echo '<div class="form-container"><div class="error-msg">Error: ' . mysqli_error($conn) . '</div></div>';
    }
}

?>

<div class="form-container">
    <h2>Edit Profile</h2>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" required>

        <label>Change Password</label>
        <input type="password" name="password" placeholder="Leave blank to keep old password">

        <br><br>

        <?php if ($user_role == 'patient') { ?>

            <label>NIC</label>
            <input type="text" name="nic" value="<?php echo isset($user['nic']) ? $user['nic'] : ''; ?>">

            <label>Mobile</label>
            <input type="text" name="mobile" value="<?php echo isset($user['mobile']) ? $user['mobile'] : ''; ?>">

            <label>Gender</label>
            <select name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male" <?php echo ($user['gender'] === "Male" ? "selected" : ""); ?>>Male</option>
                <option value="Female" <?php echo ($user['gender'] === "Female" ? "selected" : ""); ?>>Female</option>
            </select>

            <label>Address</label>
            <textarea name="address"><?php echo isset($user['address']) ? $user['address'] : ''; ?></textarea>

        <?php } ?>

        <button type="submit" name="update">Update Profile</button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
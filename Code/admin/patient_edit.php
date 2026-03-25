<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/patient_auth.php');

if (!isset($_GET['patient_id'])) {
    echo "Invalid Request!";
    exit;
}

$patient_id = $_GET['patient_id'];

// Fetch patient , username
$patient_sql = "
    SELECT p.*, u.user_name
    FROM patients p
    JOIN users u ON p.user_id = u.user_id
    WHERE p.patient_id = $patient_id
";

$patient_result = mysqli_query($conn, $patient_sql);
$patient = mysqli_fetch_assoc($patient_result);

if (!$patient) {
    echo "Patient Not Found!";
    exit;
}


// update

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $dob = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $nic = $_POST['nic'];
    $blood_group = $_POST['blood_group'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];

    $username = $_POST['user_name'];

    $sql_user = "UPDATE users 
                 SET user_name='$username'
                 WHERE user_id = {$patient['user_id']}";

    mysqli_query($conn, $sql_user);


    $sql = "UPDATE patients SET 
                name='$name',
                date_of_birth='$dob',
                gender='$gender',
                nic='$nic',
                blood_group='$blood_group',
                address='$address',
                mobile='$mobile'
            WHERE patient_id = $patient_id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: patient_index.php?msg=updated");
        exit;
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}

?>

<div class="form-container">
    <h2>Edit Patient Details</h2>

    <form action="" method="POST">

        <label>Login Username</label>
        <input type="text" name="user_name" value="<?php echo $patient['user_name']; ?>" required>

        <label>Patient Name</label>
        <input type="text" name="name" value="<?php echo $patient['name']; ?>" required>

        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" value="<?php echo $patient['date_of_birth']; ?>" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="male" <?php if ($patient['gender'] == 'male')
                echo "selected"; ?>>Male</option>
            <option value="female" <?php if ($patient['gender'] == 'female')
                echo "selected"; ?>>Female</option>
            <option value="other" <?php if ($patient['gender'] == 'other')
                echo "selected"; ?>>Other</option>
        </select>

        <label>NIC</label>
        <input type="text" name="nic" value="<?php echo $patient['nic']; ?>" required>

        <label>Blood Group</label>
        <input type="text" name="blood_group" value="<?php echo $patient['blood_group']; ?>" required>

        <label>Address</label>
        <textarea name="address" required><?php echo $patient['address']; ?></textarea>

        <label>Mobile</label>
        <input type="text" name="mobile" value="<?php echo $patient['mobile']; ?>" required>

        <button type="submit" name="update" class="submit-btn">
            <i class="fa fa-save"></i> Update Patient
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
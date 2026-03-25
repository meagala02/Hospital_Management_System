<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');

if (!isset($_GET['doctor_id'])) {
    echo "Invalid Request!";
    exit;
}

$doctor_id = $_GET['doctor_id'];

$doctor_sql = "
    SELECT d.*, u.user_name 
    FROM doctors d 
    JOIN users u ON d.user_id = u.user_id 
    WHERE d.doctor_id = $doctor_id
";
$doctor_result = mysqli_query($conn, $doctor_sql);
$doctor = mysqli_fetch_assoc($doctor_result);

if (!$doctor) {
    echo "Doctor Not Found!";
    exit;
}

if (isset($_POST['update'])) {

    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $availability_start = $_POST['availability_start'];
    $availability_end = $_POST['availability_end'];
    $consultation_charges = $_POST['consultation_charges'];
    $location = $_POST['location'];
    $qualifications = $_POST['qualifications'];
    $service_id = $_POST['service_id'];
    $username = $_POST['user_name'];

    // Update user table
    $sql_user = "UPDATE users 
                 SET user_name='$username'
                 WHERE user_id = {$doctor['user_id']}";
    mysqli_query($conn, $sql_user);


    $profile_photo = $doctor['profile_photo'];

    if (!empty($_FILES['profile_photo']['name'])) {


        $uploadDir = dirname(__DIR__) . "/img/";


        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . "_" . basename($_FILES['profile_photo']['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetPath)) {
            if (!empty($doctor['profile_photo'])) {

                $oldFile = $uploadDir . $doctor['profile_photo'];

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }


            $profile_photo = $fileName;
        }
    }
    // Update doctor table
    $sql = "UPDATE doctors SET 
                doctor_name='$doctor_name',
                specialization='$specialization',
                experience='$experience',
                availability_start='$availability_start',
                availability_end='$availability_end',
                consultation_charges='$consultation_charges',
                location='$location',
                qualifications='$qualifications',
                service_id='$service_id',
                profile_photo='$profile_photo'
            WHERE doctor_id=$doctor_id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: doctor_index.php?msg=update-success");
        exit;
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}
?>

<div class="form-container">
    <h2>Edit Doctor Details</h2>

    <form action="" method="POST" enctype="multipart/form-data">

        <label>Login Username</label>
        <input type="text" name="user_name" value="<?php echo $doctor['user_name']; ?>" required>

        <label>Doctor Name</label>
        <input type="text" name="doctor_name" value="<?php echo $doctor['doctor_name']; ?>" required>

        <label>Specialization</label>
        <textarea name="specialization" required><?php echo $doctor['specialization']; ?></textarea>

        <label>Experience</label>
        <input type="text" name="experience" value="<?php echo $doctor['experience']; ?>" required>

        <label>Availability Start</label>
        <input type="time" name="availability_start" value="<?php echo $doctor['availability_start']; ?>" required>

        <label>Availability End</label>
        <input type="time" name="availability_end" value="<?php echo $doctor['availability_end']; ?>" required>

        <label>Consultation Charges</label>
        <input type="text" name="consultation_charges" value="<?php echo $doctor['consultation_charges']; ?>" required>

        <label>Location</label>
        <input type="text" name="location" value="<?php echo $doctor['location']; ?>" required>

        <label>Qualifications</label>
        <input type="text" name="qualifications" value="<?php echo $doctor['qualifications']; ?>" required>

        <label>Choose Service</label>
        <select name="service_id" required>
            <?php
            $services = mysqli_query($conn, "SELECT service_id, name FROM services");
            while ($row = mysqli_fetch_assoc($services)) {
                $selected = ($row['service_id'] == $doctor['service_id']) ? "selected" : "";
                echo "<option value='{$row['service_id']}' $selected>{$row['name']}</option>";
            }
            ?>
        </select>

        <label>Current Photo</label><br>

        <?php if (!empty($doctor['profile_photo'])) { ?>
            <img src="../img/<?php echo $doctor['profile_photo']; ?>" width="60" height="60" style="border-radius:50%;">
            <br>
        <?php } else { ?>
            No Photo<br>
        <?php } ?>

        <label>Change Profile Photo</label>
        <input type="file" name="profile_photo" accept="image/*">


        <button type="submit" name="update" class="submit-btn">
            <i class="fa fa-save"></i> Update Doctor
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
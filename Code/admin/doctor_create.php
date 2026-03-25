<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');

if (isset($_POST['create'])) {

    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $availability_start = $_POST['availability_start'];
    $availability_end = $_POST['availability_end'];
    $consultation_charges = $_POST['consultation_charges'];
    $location = $_POST['location'];
    $qualifications = $_POST['qualifications'];
    $service_id = $_POST['service_id'];

    // Password hashing
    $plain_password = $_POST['password'];
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    $username = strtolower(str_replace(" ", "_", $doctor_name));
    $original_username = $username;
    $count = 1;

    while (true) {
        $check = mysqli_query($conn, "SELECT user_id FROM users WHERE user_name='$username'");
        if (mysqli_num_rows($check) == 0)
            break;
        $username = $original_username . $count;
        $count++;
    }

    // Insert user
    $sql_user = "INSERT INTO users (user_name, password, user_role)
                 VALUES ('$username', '$hashed_password', 'doctor')";
    $result_user = mysqli_query($conn, $sql_user);

    if ($result_user) {
        $user_id = mysqli_insert_id($conn);
    } else {
        echo "User Creation Error: " . mysqli_error($conn);
        exit;
    }

    // image upload
    $profile_photo = "";

    if (!empty($_FILES['profile_photo']['name'])) {

        $uploadDir = dirname(__DIR__) . "/img/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . "_" . basename($_FILES['profile_photo']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetPath)) {
            $profile_photo = $fileName;
        } else {
            echo "Image upload failed!";
            exit;
        }
    }
   // Insert doctor
    $sql = "INSERT INTO doctors 
    (doctor_name, specialization, experience, availability_start, availability_end,
     consultation_charges, location, qualifications, service_id, user_id, profile_photo)
    VALUES 
    ('$doctor_name', '$specialization', '$experience', '$availability_start', 
     '$availability_end', '$consultation_charges', '$location', '$qualifications', 
     '$service_id', '$user_id', '$profile_photo')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: doctor_index.php?msg=success&username=$username&password=$plain_password");
        exit;
    } else {
        echo "Doctor Insert Error: " . mysqli_error($conn);
    }
}
?>


<div class="form-container">
    <h2>Create Doctor Details</h2>

    <form action="" method="POST" enctype="multipart/form-data">

        <label>Doctor Name</label>
        <input type="text" name="doctor_name" required>

        <label>Specialization</label>
        <textarea name="specialization" required></textarea>

        <label>Experience</label>
        <input type="text" name="experience" required>

        <label>Availability Start</label>
        <input type="time" name="availability_start" required>

        <label>Availability End</label>
        <input type="time" name="availability_end" required>

        <label>Consultation Charges</label>
        <input type="text" name="consultation_charges" required>

        <label>Location</label>
        <input type="text" name="location" required>

        <label>Qualifications</label>
        <input type="text" name="qualifications" required>

        <label>Choose Service</label>
        <select name="service_id" required>
            <option value="">-- Select Service --</option>
            <?php
            $services = mysqli_query($conn, "SELECT service_id, name FROM services");
            while ($row = mysqli_fetch_assoc($services)) {
                echo "<option value='{$row['service_id']}'>{$row['name']}</option>";
            }
            ?>
        </select>

        <label>Profile Photo</label>
        <input type="file" name="profile_photo" accept="image/*">

        <label>Password (for doctor login)</label>
        <input type="password" name="password" required>

        <button type="submit" name="create" class="submit-btn">
            <i class="fa fa-save"></i> Create Doctor
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
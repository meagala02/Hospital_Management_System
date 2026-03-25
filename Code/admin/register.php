<?php
include('../inc/header.php');
include('../inc/connection.php');

$message = "";

// Registration Logic
if (isset($_POST['register'])) {

    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Patient fields
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $blood_group = $_POST['blood_group'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    // Profile photo upload
    $profile_photo = "";
    if (!empty($_FILES['profile_photo']['name'])) {
        $fileName = time() . "_" . basename($_FILES['profile_photo']['name']);
        $targetFile = "../uploads/patients/" . $fileName;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
            $profile_photo = $fileName;
        }
    }

    //Check if user_name already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE user_name='$user_name'");
    if (mysqli_num_rows($check) > 0) {
        $message = "user_name already exists!";
    } else {

        //Insert into USERS table
        $sqlUser = "INSERT INTO users (user_name, password, user_role) 
                    VALUES ('$user_name', '$password', 'patient')";
        $resultUser = mysqli_query($conn, $sqlUser);

        if ($resultUser) {

            // Get user_id
            $user_id = mysqli_insert_id($conn);

            //Insert into PATIENTS table
            $sqlPatient = "
                INSERT INTO patients 
                (user_id, name, date_of_birth, gender, nic, blood_group, address, mobile, profile_photo)
                VALUES 
                ('$user_id', '$name', '$dob', '$gender', '$nic', '$blood_group', '$address', '$mobile', '$profile_photo')
            ";

            $resultPatient = mysqli_query($conn, $sqlPatient);

            if ($resultPatient) {
                // Registration success go to login
                header("Location: login.php?success=1");
                exit;
            } else {
                $message = "Error creating patient profile!";
            }
        } else {
            $message = "Error creating user!";
        }
    }
}
?>


<div class="reg-container">
    <h2><i class="fa fa-user-plus"></i> Patient Registration</h2>

    <?php if ($message != "") { ?>
        <p class="message"><?= $message ?></p>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="input-box">
            <i class="fa fa-user"></i>
            <input type="text" name="user_name" placeholder="Create user_name" required>
        </div>

        <div class="input-box">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Create Password" required>
        </div>

        <div class="input-box">
            <i class="fa fa-id-card"></i>
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="form-row">
            <div class="input-box">
                <i class="fa fa-calendar"></i>
                <input type="date" name="date_of_birth" required>
            </div>

            <div class="input-box">
                <i class="fa fa-venus-mars"></i>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="input-box">
                <i class="fa fa-id-card-o"></i>
                <input type="text" name="nic" placeholder="NIC Number" required>
            </div>

            <div class="input-box">
                <i class="fa fa-tint"></i>
                <select name="blood_group" required>
                    <option value="">Blood Group</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>O+</option>
                    <option>O-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                </select>
            </div>
        </div>

        <div class="input-box">
            <i class="fa fa-map-marker"></i>
            <textarea name="address" placeholder="Address" required></textarea>
        </div>

        <div class="input-box">
            <i class="fa fa-phone"></i>
            <input type="text" name="mobile" placeholder="Mobile Number" required>
        </div>

        <div class="input-box">
            <i class="fa fa-camera"></i>
            <input type="file" name="profile_photo" accept="image/*">
        </div>

        <button type="submit" name="register">Register</button>
    </form>
</div>

<?php include('../inc/footer.php'); ?>
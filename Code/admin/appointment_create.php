<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/patient_auth.php');
// is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/login.php?error=not_logged_in");
    exit;
}
// Get patient_id using user_id
$user_id = $_SESSION['user_id'];
$pQuery = "SELECT patient_id FROM patients WHERE user_id = '$user_id'";
$pResult = mysqli_query($conn, $pQuery);
$patient = mysqli_fetch_assoc($pResult);

$patient_id = $patient['patient_id'];
if (isset($_POST['submit'])) {

    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $doctor_id = $_POST['doctor_id'];
    //Get doctor's availability
    $docQuery = "SELECT availability_start, availability_end 
                 FROM doctors 
                 WHERE doctor_id = '$doctor_id'";

    $docResult = mysqli_query($conn, $docQuery);
    $doctor = mysqli_fetch_assoc($docResult);

    $available_from = $doctor['availability_start'];
    $available_to = $doctor['availability_end'];


    //Check if appointment_time is inside the available
    if ($appointment_time < $available_from || $appointment_time > $available_to) {
        $errorMessage = "Appointment not available for this time. Please check doctor's availability on their profile.";
    } else {

        //add appointment
        $sql = "INSERT INTO appointments (appointment_date, appointment_time, patient_id, doctor_id)
                VALUES ('$appointment_date', '$appointment_time', '$patient_id', '$doctor_id')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: appointment_index.php?msg=success");
            exit;
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}

?>

<div class="form-container">
    <h2>Book Appointment</h2>

    <?php if (isset($errorMessage)): ?>
        <div class="error-msg"><?php echo $errorMessage; ?></div>
    <?php endif; ?>


    <form action="" method="POST">

        <label for="appointment_date">Appointment Date</label>
        <input type="date" id="appointment_date" name="appointment_date" required>

        <label for="appointment_time">Appointment Time</label>
        <input type="time" id="appointment_time" name="appointment_time" required>

        <label for="doctor_id">Select Doctor</label>
        <select id="doctor_id" name="doctor_id" required>
            <option value="">-- Select Doctor --</option>
            <?php
            $docQuery = "SELECT doctor_id, doctor_name FROM doctors";
            $docResult = mysqli_query($conn, $docQuery);

            while ($doc = mysqli_fetch_assoc($docResult)) {
                echo "<option value='" . $doc['doctor_id'] . "'>" . $doc['doctor_name'] . "</option>";
            }
            ?>
        </select>

        <button type="submit" name="submit" class="submit-btn">
            <i class="fa fa-save"></i> Book Appointment
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
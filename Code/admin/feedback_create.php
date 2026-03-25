<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/patient_auth.php');


// Get patient_id from session user_id
$user_id = $_SESSION['user_id'];
$pQuery = "SELECT patient_id FROM patients WHERE user_id = '$user_id'";
$pResult = mysqli_query($conn, $pQuery);
$patient = mysqli_fetch_assoc($pResult);

$patient_id = $patient['patient_id'];

// Get appointment_id from URL
if (!isset($_GET['appointment_id'])) {
    die("<div class='error-msg'>No appointment selected!</div>");
}

$appointment_id = $_GET['appointment_id'];
if (isset($_POST['submit'])) {

    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $rating = $_POST['rating'];

    $sql = "INSERT INTO feedbacks (content, rating, patient_id, appointment_id)
            VALUES ('$content', '$rating', '$patient_id', '$appointment_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: feedback_index.php?msg=success");
        exit;
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="form-container">
    <h2>Give Feedback</h2>

    <?php if (isset($errorMessage)): ?>
        <div class="error-msg"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form action="" method="POST">

        <label for="content">Your Feedback</label>
        <textarea id="content" name="content" rows="4" required></textarea>

        <label for="rating">Rating (1 to 5)</label>
        <select id="rating" name="rating" required>
            <option value=""> Select Rating </option>
            <option value="1">⭐ 1</option>
            <option value="2">⭐ 2</option>
            <option value="3">⭐ 3</option>
            <option value="4">⭐ 4</option>
            <option value="5">⭐ 5</option>
        </select>

        <button type="submit" name="submit" class="submit-btn">
            <i class="fa fa-save"></i> Submit Feedback
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
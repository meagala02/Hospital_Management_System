<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');

// add test result
if (isset($_POST['submit'])) {

    $test_type = $_POST['test_type'];
    $test_date = $_POST['test_date'];
    $patient_id = $_POST['patient_id'];

    $file_name = "";

    if (!empty($_FILES['result_file']['name'])) {

        $file_name = time() . "_" . basename($_FILES['result_file']['name']);

        $target_path = __DIR__ . "/img/" . $file_name;


        move_uploaded_file($_FILES['result_file']['tmp_name'], $target_path);
    }

    $sql = "INSERT INTO test_results (test_type, test_date, result_file, patient_id)
            VALUES ('$test_type', '$test_date', '$file_name', '$patient_id')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: test_result_view.php?msg=success");
        exit;
    } else {
        echo "Insert Error: " . mysqli_error($conn);
    }
}

?>

<div class="form-container">
    <h2>Add Test Result</h2>

    <form action="" method="POST" enctype="multipart/form-data">

        <label>Test Type</label>
        <input type="text" name="test_type" required>

        <label>Test Date</label>
        <input type="date" name="test_date" required>

        <label>Select Patient</label>
        <select name="patient_id" required>
            <option value="">-- Select Patient --</option>

            <?php
            $patients = mysqli_query($conn, "SELECT patient_id, name FROM patients");

            while ($row = mysqli_fetch_assoc($patients)) {
                echo "<option value='{$row['patient_id']}'>{$row['patient_id']} - {$row['name']}</option>";
            }
            ?>
        </select>

        <label>Upload Test Result (PDF/Image)</label>
        <input type="file" name="result_file" required>

        <button type="submit" name="submit" class="submit-btn">
            <i class="fa fa-save"></i> Add Test Result
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
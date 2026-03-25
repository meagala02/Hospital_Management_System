<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/patient_auth.php');
include('../inc/session.php');

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

if ($user_role == 'doctor') {
    echo "<script>alert('Access Denied! Only patients and admin can view test results.'); 
          window.location='../admin/index.php';</script>";
    exit;
}



if ($user_role == 'patient') {
    $query = "SELECT patient_id FROM patients WHERE user_id = '$user_id' LIMIT 1";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $patient_id = $row['patient_id'];
}

//Fetch test result based on role 
$sql = "SELECT 
            t.test_id,
            t.test_type,
            t.test_date,
            t.result_file,
            p.name AS patient_name
        FROM test_results t
        JOIN patients p ON t.patient_id = p.patient_id";

if ($user_role == 'patient') {
    $sql .= " WHERE t.patient_id = '$patient_id'";
}

$sql .= " ORDER BY t.test_id DESC";

$result = mysqli_query($conn, $sql);

// DELETE Admin only

if ($user_role == 'admin' && isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $fileQuery = mysqli_query($conn, "SELECT result_file FROM test_results WHERE test_id = $delete_id");
    $fileRow = mysqli_fetch_assoc($fileQuery);

    if (!empty($fileRow['result_file'])) {
        $filePath = "../img/" . $fileRow['result_file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $delSql = "DELETE FROM test_results WHERE test_id = $delete_id";
    if (mysqli_query($conn, $delSql)) {
        echo "<script>alert('Test result deleted successfully'); window.location='test_result_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting test result');</script>";
    }
}

?>

<div class="table-container">

    <div class="header-row">
        <h2>
            <?php
            if ($user_role == 'admin')
                echo "All Test Results";
            else
                echo "My Test Results";
            ?>
        </h2>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
        <div class="alert-success">
            Test result added successfully!
        </div>
    <?php } ?>

    <table class="custom-table">
        <tr>
            <th>ID</th>
            <th>Test Type</th>
            <th>Date</th>
            <th>Patient</th>
            <th>File</th>
            <th>Actions</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $row['test_id']; ?></td>
                    <td><?= $row['test_type']; ?></td>
                    <td><?= $row['test_date']; ?></td>
                    <td><?= $row['patient_name']; ?></td>

                    <td>
                        <?php if (!empty($row['result_file'])) { ?>
                            <a class="action-btn download-btn" href="../img/<?php echo $row['result_file']; ?>" download>
                                <i class="fa fa-download"></i> Download
                            </a>
                        <?php } else { ?>
                            No File
                        <?php } ?>

                    </td>

                    <td>
                        <?php if ($user_role == 'admin') { ?>
                            <a class="action-btn delete-btn" href="test_result_index.php?delete=<?= $row['test_id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this result?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        <?php } else { ?>
                            —
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="10" style="text-align:center;">No test results found</td>
            </tr>
        <?php } ?>
    </table>

</div>

<?php include('../inc/footer.php'); ?>
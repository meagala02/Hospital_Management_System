<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/session.php');

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

if ($user_role == 'doctor') {
    echo "<script>alert('Access Denied! Only patients and admin can view feedback.'); 
          window.location='../admin/index.php';</script>";
    exit;
}

// Get patient_id if patient
if ($user_role == 'patient') {
    $query = "SELECT patient_id FROM patients WHERE user_id = '$user_id' LIMIT 1";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $patient_id = $row['patient_id'];
}

// Fetch Feedback based on role
$sql = "SELECT 
            f.feedback_id,
            f.content,
            f.rating,
            f.appointment_id,

            a.appointment_date,
            a.appointment_time,

            d.doctor_name,
            p.name AS patient_name
        FROM feedbacks f
        JOIN appointments a ON f.appointment_id = a.appointment_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
        JOIN patients p ON a.patient_id = p.patient_id";

// Apply role filter
if ($user_role == 'patient') {
    $sql .= " WHERE f.patient_id = '$patient_id'";
}

$sql .= " ORDER BY f.feedback_id DESC";

$result = mysqli_query($conn, $sql);


// DELETE — Admin only
if ($user_role == 'admin' && isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delSql = "DELETE FROM feedbacks WHERE feedback_id = $delete_id";
    if (mysqli_query($conn, $delSql)) {
        echo "<script>alert('Feedback deleted successfully'); window.location='feedback_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting feedback');</script>";
    }
}
?>

<div class="table-container">

    <div class="header-row">
        <h2>
            <?php
            if ($user_role == 'admin')
                echo "All Feedback";
            else
                echo "My Feedback";
            ?>
        </h2>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
        <div class="alert-success">
            Feedback submitted successfully!
        </div>
    <?php } ?>

    <table class="custom-table">
        <tr>
            <th>ID</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>

            <?php if ($user_role == 'admin') { ?>
                <th>Patient</th>
            <?php } ?>

            <th>Actions</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $row['feedback_id']; ?></td>
                    <td><?= $row['rating']; ?> ⭐</td>
                    <td><?= $row['content']; ?></td>
                    <td><?= $row['doctor_name']; ?></td>
                    <td><?= $row['appointment_date']; ?></td>
                    <td><?= $row['appointment_time']; ?></td>

                    <?php if ($user_role == 'admin') { ?>
                        <td><?= $row['patient_name']; ?></td>
                    <?php } ?>

                    <td>
                        <?php if ($user_role == 'admin') { ?>
                            <a class="action-btn delete-btn" href="feedback_index.php?delete=<?= $row['feedback_id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this feedback?');">
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
                <td colspan="10" style="text-align:center;">No feedback found</td>
            </tr>
        <?php } ?>
    </table>

</div>

<?php include('../inc/footer.php'); ?>
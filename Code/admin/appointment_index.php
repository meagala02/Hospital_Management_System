<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/session.php');

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
// Patient get patient_id
if ($user_role == 'patient') {
    $query = "SELECT patient_id FROM patients WHERE user_id = '$user_id' LIMIT 1";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $patient_id = $row['patient_id'];
}
// Doctor get doctor_id
if ($user_role == 'doctor') {
    $query = "SELECT doctor_id FROM doctors WHERE user_id = '$user_id' LIMIT 1";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $doctor_id = $row['doctor_id'];
}
// Fetch appoinment base one user role
$sql = "SELECT 
            a.appointment_id,
            a.appointment_date,
            a.appointment_time,

            p.name AS patient_name,
            d.doctor_name AS doctor_name,
            d.specialization
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN doctors d ON a.doctor_id = d.doctor_id";
// Filter
if ($user_role == 'patient') {
    $sql .= " WHERE a.patient_id = '$patient_id'";
} elseif ($user_role == 'doctor') {
    $sql .= " WHERE a.doctor_id = '$doctor_id'";
}

$sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$result = mysqli_query($conn, $sql);

// DELETE (Admin only)
if ($user_role == 'admin' && isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delSql = "DELETE FROM appointments WHERE appointment_id = $delete_id";
    if (mysqli_query($conn, $delSql)) {
        echo "<script>alert('Appointment deleted successfully'); window.location='appointment_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting appointment');</script>";
    }
}
?>

<div class="table-container">

    <div class="header-row">
        <h2>
            <?php
            if ($user_role == 'admin')
                echo "All Appointments";
            elseif ($user_role == 'doctor')
                echo "Appointments for You";
            else
                echo "Your Appointments";
            ?>
        </h2>

        <?php if ($user_role == 'patient') { ?>
            <a class="create-btn" href="appointment_create.php">
                <i class="fa fa-plus"></i> Book Appointment
            </a>
        <?php } ?>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
        <div class="alert-success">
            Appointment booked successfully!
        </div>
    <?php } ?>

    <table class="custom-table">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Time</th>

            <?php if ($user_role != 'doctor') { ?>
                <th>Doctor</th>
                <th>Specialization</th>
            <?php } ?>

            <?php if ($user_role != 'patient') { ?>
                <th>Patient</th>
            <?php } ?>

           <th>Actions</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $row['appointment_id']; ?></td>
                    <td><?= $row['appointment_date']; ?></td>
                    <td><?= $row['appointment_time']; ?></td>

                    <?php if ($user_role != 'doctor') { ?>
                        <td><?= $row['doctor_name']; ?></td>
                        <td><?= $row['specialization']; ?></td>
                    <?php } ?>

                    <?php if ($user_role != 'patient') { ?>
                        <td><?= $row['patient_name']; ?></td>
                    <?php } ?>

                    <td>
                        <?php if ($user_role == 'patient') { ?>
                        <a href="feedback_create.php?appointment_id=<?php echo $row['appointment_id']; ?>" class="action-btn edit-btn">
                            Give Feedback
                        </a>
                        <?php } else { ?>
                            —
                        <?php } ?>

                        <?php if ($user_role == 'admin') { ?>
                            <a class="action-btn delete-btn" href="appointment_index.php?delete=<?= $row['appointment_id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this appointment?');">
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
                <td colspan="10" style="text-align:center;">No appointments found</td>
            </tr>
        <?php } ?>
    </table>

</div>

<?php include('../inc/footer.php'); ?>
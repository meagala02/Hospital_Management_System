<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');

// Fetch doctors,service name
$sql = "
    SELECT d.*, s.name AS service_name 
    FROM doctors d
    LEFT JOIN services s ON d.service_id = s.service_id
";
$result = mysqli_query($conn, $sql);

// Delete Doctor
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $sql = "DELETE FROM doctors WHERE doctor_id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Doctor deleted successfully'); window.location='doctor_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting');</script>";
    }
}
?>

<div class="table-container">

    <div class="header-row">
        <h2>Doctors List</h2>

        <a class="create-btn" href="doctor_create.php">
            <i class="fa fa-plus"></i> Add Doctor
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
        <div class="alert-success">
            Doctor added successfully!
        </div>
    <?php } ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "update-success") { ?>
        <div class="alert-success">
            Doctor updated successfully!
        </div>
    <?php } ?>

    <table class="custom-table">
        <tr>
            <th>Doctor ID</th>
            <th>Doctor Name</th>
            <th>Specialization</th>
            <th>Availability Start</th>
            <th>Availability End</th>
            <th>Consultation Charges</th>
            <th>Location</th>
            <th>Service</th>
            <th>Profile Photo</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['doctor_id']; ?></td>
                <td><?php echo $row['doctor_name']; ?></td>
                <td><?php echo $row['specialization']; ?></td>
                <td><?php echo $row['availability_start']; ?></td>
                <td><?php echo $row['availability_end']; ?></td>
                <td><?php echo $row['consultation_charges']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['service_name']; ?></td>

                <td>
                    <?php if (!empty($row['profile_photo'])) { ?>
                        <img src="../img/<?php echo $row['profile_photo']; ?>" width="60" height="60"
                            style="border-radius:50%;">
                    <?php } else { ?>
                        No Photo
                    <?php } ?>
                </td>
                <td>
                    <a class="action-btn edit-btn" href="doctor_edit.php?doctor_id=<?php echo $row['doctor_id']; ?>">
                        <i class="fa fa-pen"></i> Edit
                    </a>

                    <a class="action-btn delete-btn" href="doctor_index.php?delete=<?php echo $row['doctor_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this doctor information?');">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

<?php include('../inc/footer.php'); ?>
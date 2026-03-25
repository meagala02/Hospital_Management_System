<?php
include('../inc/header.php');
include('../inc/connection.php');


// Fetch all patients
$sql = "SELECT * FROM patients";
$result = mysqli_query($conn, $sql);

// Delete Patient
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $sql = "DELETE FROM patients WHERE patient_id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Patient deleted successfully'); window.location='patient_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting patient');</script>";
    }
}
?>

<div class="table-container">

    <div class="header-row">
        <h2>Patients List</h2>
    </div>


    <table class="custom-table">
        <tr>
            <th>Patient ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>NIC</th>
            <th>Blood Group</th>
            <th>Address</th>
            <th>Mobile</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['patient_id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['date_of_birth']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['nic']; ?></td>
                <td><?php echo $row['blood_group']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['mobile']; ?></td>



                <td>
                    <!--Delete -->
                    <a class="action-btn delete-btn" href="patient_index.php?delete=<?php echo $row['patient_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this patient?');">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

<?php include('../inc/footer.php'); ?>
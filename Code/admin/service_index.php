<?php include('../inc/header.php');
include('../inc/connection.php');

$sql = "SELECT * FROM services";
$result = mysqli_query($conn, $sql);
include('../inc/middleware/admin_auth.php');


// Delete 
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $sql = "DELETE FROM services WHERE service_id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Service deleted successfully'); window.location='service_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting');</script>";
    }
}

?>
<div class="table-container">

    <div class="header-row">
        <h2>Services List</h2>

        <a class="create-btn" href="service_create.php">
            <i class="fa fa-plus"></i> Create Service
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
        <div class="alert-success">
            Service added successfully!
        </div>
    <?php } ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "update-success") { ?>
        <div class="alert-success">
            Service updated successfully!
        </div>
    <?php } ?>


    <table class="custom-table">
        <tr>
            <th>ID</th>
            <th>Service Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['service_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <a class="action-btn edit-btn" href="service_edit.php?id=<?php echo $row['service_id']; ?>">
                        <i class="fa fa-pen"></i> Edit
                    </a>

                    <a class="action-btn delete-btn" href="service_index.php?delete=<?php echo $row['service_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this service?');">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>


<?php include('../inc/footer.php'); ?>
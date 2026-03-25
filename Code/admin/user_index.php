<?php
include('../inc/header.php');
include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

// Delete User
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE user_id = $delete_id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('User deleted successfully'); window.location='user_index.php';</script>";
    } else {
        echo "<script>alert('Error deleting user');</script>";
    }
}
?>

<div class="table-container">

    <div class="header-row">
        <h2>Users List</h2>

        <a class="create-btn" href="user_create.php">
            <i class="fa fa-plus"></i> Create User
        </a>
    </div>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
        <div class="alert-success">
            User added successfully!
        </div>
    <?php } ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == "updated") { ?>
        <div class="alert-success">
            User updated successfully!
        </div>
    <?php } ?>

    <table class="custom-table">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>User Role</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo ucfirst($row['user_role']); ?></td>

                <td>
                    <a class="action-btn edit-btn" href="user_edi.php?user_id=<?php echo $row['user_id']; ?>">
                        <i class="fa fa-pen"></i> Edit
                    </a>

                    <a class="action-btn delete-btn" href="user_index.php?delete=<?php echo $row['user_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this user?');">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include('../inc/footer.php'); ?>
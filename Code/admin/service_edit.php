<?php include('../inc/header.php');

include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');


$id = $_GET['id'];

$sql = "SELECT * FROM services WHERE service_id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $update = "UPDATE services SET name='$name', description='$description' WHERE service_id=$id";
    $result = mysqli_query($conn, $update);

    if ($result) {
        header("Location: service_index.php?msg=update-success");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<div class="form-container">
    <h2>Edit Service</h2>

    <form action="" method="POST">

        <label for="name">Service Name</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea>

        <button type="submit" name="update" class="submit-btn">
            <i class="fa fa-save"></i> Update Service
        </button>

    </form>
</div>


<?php include('../inc/footer.php'); ?>
<?php include('../inc/header.php');

include('../inc/connection.php');
include('../inc/middleware/admin_auth.php');


if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO services (name, description) VALUES ('$name', '$description')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: service_index.php?msg=success");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


?>


<div class="form-container">
    <h2>Add New Service</h2>

    <form action="" method="POST">

        <label for="name">Service Name</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>

        <button type="submit" name="submit" class="submit-btn">
            <i class="fa fa-save"></i> Add Service
        </button>

    </form>
</div>

<?php include('../inc/footer.php'); ?>
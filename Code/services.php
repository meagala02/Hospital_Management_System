<?php include('inc/header.php'); ?>
<?php include('inc/connection.php');

$sql = "SELECT * FROM services";
$result = mysqli_query($conn, $sql);

?>

<div class="services-container">
    <h1 class="page-title">Our Services</h1>

    <div class="services-grid">

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <article class="service-box">
                <div class="service-title">
                    <span class="service-badge"><?php echo $row['service_id']; ?></span>
                    <span><?php echo $row['name']; ?></span>
                </div>

                <p class="service-desc">
                    <?php echo $row['description']; ?>
                </p>

                <div class="service-meta">
                    Available time: <strong>Based on Doctor Availability</strong>
                </div>
            </article>
        <?php } ?>

    </div>
</div>

<?php include('inc/footer.php'); ?>
<?php
include('inc/header.php');
include('inc/connection.php');

$service_sql = "SELECT * FROM services ORDER BY name ASC";
$service_result = mysqli_query($conn, $service_sql);

$filter_service = "";
$filter_query = "";

if (isset($_GET['service']) && $_GET['service'] != "") {
    $filter_service = $_GET['service'];
    $filter_query = " WHERE d.service_id = '$filter_service' ";
}
$sql = "
    SELECT d.*, s.name AS service_name 
    FROM doctors d
    LEFT JOIN services s ON d.service_id = s.service_id
    $filter_query
";
$result = mysqli_query($conn, $sql);
?>

<main class="page" aria-label="Doctors list">

    <h1 class="page-title">Doctors</h1>

    <form method="GET" class="filter-box" style="margin-bottom:20px; display:flex; gap:10px; align-items:center;">

        <label style="font-weight:600;">Find your Service:</label>

        <select name="service" class="service-select">
            <option value="">-- All Services --</option>

            <?php while ($srv = mysqli_fetch_assoc($service_result)) { ?>
                <option value="<?php echo $srv['service_id']; ?>" <?php if ($filter_service == $srv['service_id'])
                       echo "selected"; ?>>
                    <?php echo $srv['name']; ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" class="search-btn small-btn">Search</button>

    </form>

    <section class="doctors-container">

        <?php
        while ($row = mysqli_fetch_assoc($result)) {

            $photo_path = "";
            if (!empty($row['profile_photo'])) {
                $full_path = __DIR__ . "/img/" . $row['profile_photo'];
                if (file_exists($full_path)) {
                    $photo_path = "img/" . $row['profile_photo'];
                }
            }

            $initials = "";
            foreach (explode(" ", $row['doctor_name']) as $p) {
                if ($p !== "")
                    $initials .= strtoupper($p[0]);
                if (strlen($initials) >= 2)
                    break;
            }
            ?>

            <article class="doctor-card">

                <div class="card-head">

                    <?php if ($photo_path) { ?>
                        <img src="<?php echo $photo_path; ?>" class="avatar-img big-avatar" alt="Doctor Photo">
                    <?php } else { ?>
                        <div class="avatar big-avatar"><?php echo $initials; ?></div>
                    <?php } ?>

                    <div class="meta">
                        <div class="name"><?php echo $row['doctor_name']; ?></div>
                        <div class="specialization"><?php echo $row['qualifications']; ?></div>
                    </div>
                </div>

                <details>
                    <summary class="small-summary">
                        <svg class="chev" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        More
                    </summary>

                    <div class="more-content">

                        <div class="row">
                            <div class="label">Service Name:</div>
                            <div class="value"><?php echo $row['service_name']; ?></div>
                        </div>

                        <div class="row">
                            <div class="label">Experience:</div>
                            <div class="value"><?php echo $row['experience']; ?> Years</div>
                        </div>

                        <div class="row">
                            <div class="label">Availability:</div>
                            <div class="value">
                                <ul class="services-list">
                                    <li>Start: <?php echo $row['availability_start']; ?></li>
                                    <li>End: <?php echo $row['availability_end']; ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Consultation Fee:</div>
                            <div class="value">LKR <?php echo $row['consultation_charges']; ?></div>
                        </div>

                    </div>
                </details>

            </article>

        <?php } ?>

    </section>

</main>

<?php include('inc/footer.php'); ?>
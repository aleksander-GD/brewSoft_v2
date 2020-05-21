<!DOCTYPE html>
<html>

<head>
    <title> Manager Dashboard </title>
    <?php include_once '../app/views/partials/head.php'; ?>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/brewdashboard.css">
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>
    <?php endif; ?>

<?php include '../app/views/partials/foot.php'; ?>
<!DOCTYPE html>

<head>
    <title>manager index</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
        <?php include_once '../app/views/partials/menu.php'; ?>
    <?php else : ?>
    
    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>

</html>
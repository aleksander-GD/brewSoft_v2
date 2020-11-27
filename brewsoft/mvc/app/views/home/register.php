<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <?php include_once '../app/views/partials/head.php'; ?>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/stylesheet.css">
</head>

<body>
    <div class="col-sm-10 col-sm offset-1">
        <h3 class="display-3">Registration page</h3>
        <div class=wrapper>
            <form class="Signup form" action="/brewsoft/mvc/public/home/register" method="POST">
                <div class="form-group">
                    <label for="username"> Username:</label> <br>
                    <input type="text" name="username" placeholder="username" class="form-control"> <br>
                </div>
                <div class="form-group">
                    <label for="password"> password:</label> <br>
                    <input type="password" name="password" placeholder="password" class="form-control"> <br>
                </div>
                <div class="form-group">
                    <label for="usertype"> usertype:</label> <br>
                    <select name="usertype" id="usertype" class="select-css">
                        <option value="Manager">Manager</option>
                        <option value="Worker">Worker</option>
                        <option value="Admin">Admin</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <input type="submit" name="Signup" id="Signup" class="btn btn-primary" value="Signup" />
                    <a href="/brewSoft/mvc/public/home/login" class="btn btn-primary" role="button" aria-pressed="true">Login page</a>
                </div>
        </div>
    </div>

    <?php include '../app/views/partials/foot.php'; ?>
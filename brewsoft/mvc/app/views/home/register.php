<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <?php include_once '../app/views/partials/head.php'; ?>
</head>

<body>
    <div class=wrapper>
        <h1> Registration page </h1>

        <form class="Signup form" action="/brewsoft/mvc/public/home/register" method="POST">
            <label for="username"> Username:</label> <br>
            <input type="text" name="username" placeholder="username"> <br>
            <label for="password"> password:</label> <br>
            <input type="password" name="password" placeholder="password"> <br>
            <label for="usertype"> usertype:</label> <br>
            <select name="usertype" id="usertype">
                <option value="Manager">Manager</option>
                <option value="Worker">Worker</option>
                <option value="Admin">Admin</option>
            </select><br>
            <input type="submit" name="Signup" id="Signup" class="btn btn-primary" value="Signup" />
            <a href="/brewSoft/mvc/public/home/login" class="btn btn-primary" role="button" aria-pressed="true">Login page</a>
    </div>

    <?php include '../app/views/partials/foot.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <button type="submit" name="Signup">Signup</button>
    </div>

    <?php include '../app/views/partials/foot.php'; ?>

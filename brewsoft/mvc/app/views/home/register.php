<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   
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
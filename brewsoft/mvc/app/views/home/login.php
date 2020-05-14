<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="wrapper">
        <h4>Login</h4>
        <form action="/brewsoft/mvc/public/home/login" method="POST">
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" name="username" class="form-control" />
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" name="login" id="login" class="btn btn-primary" value="login" />
                <a href="/brewSoft/mvc/public/home/register" class="btn btn-primary" role="button" aria-pressed="true">Register</a>
            </div>
        </form>
    </div>
    <?php include '../app/views/partials/foot.php'; ?>
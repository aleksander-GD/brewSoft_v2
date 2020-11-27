<!DOCTYPE html>
<html>

<head>
    <title>Log in</title>
    <?php include_once '../app/views/partials/head.php'; ?>
</head>

<body>
    <div class="col-sm-10 col-sm offset-1">
        <h3 class="display-3">Login</h3>
        <div class="wrapper">
           
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
    </div>
    <?php include '../app/views/partials/foot.php'; ?>
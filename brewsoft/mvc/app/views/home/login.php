<head>
    <title>Login</title>
    <meta charset="utf-8" />
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
                <input type="submit" name="login" id="login" value="login" />
            </div>
        </form>
    </div>
</body>
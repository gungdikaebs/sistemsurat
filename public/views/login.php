<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/views/assets/css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <img src="<?= BASE_URL; ?>public/views/assets/img/logo.jpeg" alt="">
        <section class="page-login">
            <div class="header">
                <h1>Sign In</h1>
                <p>Sign In entering the information below</p>
            </div>
            <form action="<?= BASE_URL; ?>login" method="post">
                <div class="form-control">
                    <label for="username">Username </label>
                    <input type="text" name="username" placeholder="Username" id="username">
                </div>
                <div class="form-control">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" id="password">
                </div>
                <div class="form-control">
                    <button type="submit" name="submit_login">Login</button>
                </div>
            </form>
        </section>

    </div>


</body>

</html>
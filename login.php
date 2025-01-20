<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Picture</title>
    <link rel="icon" href="img/logo4.jpg" type="image/jpg">
    <link rel="stylesheet" href="css/register.css"> 
</head>
<body style = "background-image: url('images/bg.jpg'); ">
<div class="container">
        <!-- Login Form -->
        <div class="login-wrap" id="login-form">
        <h2>Login</h2>
        <form action="ceklogin.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" placeholder="Username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Password"required><br><br>
            <button type="submit">Login</button>
        </form>
        <div class="footer">
            <p>Make an account? <a href="register.php" style="color: #FFA500; text-decoration: none;" onmouseover="this.style.color='#0066ff'" onmouseout="this.style.color='#FFA500'">Register</a></p>
        </div>
    </div>
</body>
</html>

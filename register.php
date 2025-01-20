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
        <h2>Form Register</h2>
        <form action="submit_register.php" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="namalengkap">Nama Lengkap:</label><br>
            <input type="text" id="namalengkap" name="namalengkap" placeholder="Nama Lengkap" required>

            <label for="alamat">Alamat:</label><br>
            <input type="text" id="addres" name="addres" placeholder="Alamat" required>
            
            <button type="submit">Register</button>
        </form>
        <div class="footer">
            <p>Already have an account? <a href="login.php" style="color: #FFA500; text-decoration: none;" onmouseover="this.style.color='#0066ff'" onmouseout="this.style.color='#FFA500'">Login</a></p>
        </div>
    </div>
</body>
</html>

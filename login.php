<?php
$message = ""; // Initialize an empty message variable

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (!empty($username) && !empty($password)) {
        $link = mysqli_connect("localhost", "root", "", "dim");
        
        if ($link === false) {
            die(mysqli_connect_error());
        }
        
        $sql = "SELECT * FROM users WHERE Username='$username' AND Password='$password'";
        $result = mysqli_query($link, $sql);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            
            if ($row) {
                header("Location: menu.php");
                exit(); // Ensure that no further code is executed after the header is sent
            } else {
                $message = "Invalid username or password";
            }
        } else {
            $message = "Something went wrong with the query";
        }
        
        mysqli_close($link);
    } else {
        $message = "Please provide both username and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Intenz Furniture Website</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <form id="login-form" action="" method="post">
            <h1>Log in</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn" name="submit">Log In</button>

            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
		<script>
    document.getElementById("login-form").addEventListener("submit", function(event) {
        <?php
        if (!empty($message) && strpos($message, 'Invalid') !== false) {
            echo "alert('$message');";
        } else {
            echo "window.location.href = 'menu.php';";
        }
        ?>
    });
</script>
    </div>
</body>

</html>

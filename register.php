<?php
$message = ""; // Initialize an empty message variable

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $nohandphone = $_POST["nohandphone"];
    $password = $_POST["password"];
    
    if (!empty($username) && !empty($email) && !empty($nohandphone) && !empty($password)){
        $link = mysqli_connect("localhost", "root", "", "dim");
        if($link == false){
            die(mysqli_connect_error());
        }
        
        $sql = "INSERT INTO users (Username, Email, NoHandphone, Password) VALUES ('$username', '$email', '$nohandphone', '$password')";
        if(mysqli_query($link, $sql)){
            $message = "Record inserted successfully";
        } else {
            $message = "Something went wrong";
        }

        mysqli_close($link);
    } else {
        $message = "Please provide all information";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Register</title>
    <style>
        /* Add styles for the popup */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            z-index: 1000;
			color: black;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Register</h1>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="number" name="nohandphone" placeholder="No Handphone" required>
                <i class='bx bxs-phone'></i>
            </div>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="submit" class="btn">Submit</button>
            <div class="register-link">
                <p>Have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
        <!-- Popup div -->
        <div id="popup" class="popup">
            <p><?php echo $message; ?></p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <!-- JavaScript to display the popup and redirect to login.php -->
    <script>
        // Display the popup when the message is not empty
        <?php if (!empty($message)) : ?>
            document.getElementById('popup').style.display = 'block';
        <?php endif; ?>

        // Function to close the popup and redirect to login.php
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>

<?php
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
                echo "Login successful!";
                // You may perform additional actions, such as setting session variables, after successful login.
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "Something went wrong with the query";
        }
        
        mysqli_close($link);
    } else {
        echo "Please provide both username and password";
    }
}
?>

<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $nohandphone = $_POST["nohandphone"];
    $password = $_POST["password"];
    if (!empty($username) && !empty($email) && !empty($nohandphone) && !empty($password)){
        $link = mysqli_connect("localhost","root","","dim");
        if($link==false){
            die(mysqli_connect_error());
        }
        $sql = "INSERT INTO users (Username, Email, NoHandphone, Password) VALUES ('$username', '$email', '$nohandphone', '$password')";
        if(mysqli_query($link,$sql)){
            echo "record inserted successfully";
        }else{
            echo "something went wrong";

        }
    }else{
        echo "please provide all information";
    }
}
?> 

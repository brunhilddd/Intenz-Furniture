<?php
$servername = "localhost";  // Change this to your MySQL server host
$username = "root";         // Change this to your MySQL username
$password = "";             // Change this to your MySQL password
$dbname = "dim";            // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

$message = ""; // Initialize an empty message variable

if (isset($_POST["submit"])) {
    $firstName = $_POST["newFirstName"];
    $lastName = $_POST["newLastName"];
    $email = $_POST["newEmail"];
    $phone = $_POST["newPhone"];
    $city = $_POST["newCity"];
    $streetname = $_POST["newStreetHome"];
    $postcode = $_POST["newPostCode"];
    $housenumber = $_POST["newHouseNumber"];

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($city) && !empty($streetname) && !empty($postcode) && !empty($housenumber)) {
        $sql = "INSERT INTO customers (newFirstName, newLastName, newEmail, newPhone, newCity, newStreetName, newPostCode, newHouseNumber) VALUES ('$firstName', '$lastName', '$email', '$phone', '$city', '$streetname', '$postcode', '$housenumber')";

        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Please provide all information";
    }
}

echo json_encode([
    'firstName' => $firstName,
    'lastName' => $lastName,
    'email' => $email,
    'phone' => $phone,
    'city' => $city,
    'streetHome' => $streetname,
    'postCode' => $postcode,
    'houseNumber' => $housenumber,
]);

$conn->close(); // Close the database connection
?>

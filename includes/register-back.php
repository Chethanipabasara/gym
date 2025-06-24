<?php

header('Content-Type: application/json');

$fullname = $_POST['fullName'] ?? '';
$phone = $_POST['phone'] ?? '';
$username = $_POST['userName'] ?? '';
$password = $_POST['password'] ?? '';
$userType = "User";

if(empty($fullname) || empty($phone) || empty($username) || empty($password)){
    echo json_encode(["success" => false, "message" => "All Fields Required"]);
    exit;
}

$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

$host = "localhost";
$user = "root";
$password="";
$database="gym";

$conn = new mysqli($host, $user, $password,$database);

if($conn->connect_error){
    echo json_encode([
        "title"=> "Error",
        "message"=> "Database Connection Failed!",
        "status"=> "error"
    ]);
    exit;
}

$query = $conn->prepare("INSERT INTO users (fullName, phone, userName, password, user_type)
VALUES (?, ?, ?, ?, ?)");
$query->bind_param("sssss", $fullname, $phone, $username, $hashedpassword, $userType);

if($query->execute()){
    echo json_encode(["success" => true, "message" => "User Registered"]);
}else{
    echo json_encode(["success" => false, "message" => "Username Already Exists"]);
}
$query->close();
$conn->close();
?>
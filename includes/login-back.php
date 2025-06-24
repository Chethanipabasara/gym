<?php 
header('Content-Type:application/json');

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

$username = $_POST['userName']?? "";
$pass  = $_POST['password'] ?? "";


$sql = "SELECT * FROM users WHERE userName= ?";
$stmt = $conn->prepare($sql);
$stmt-> bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if($userData && password_verify($pass, $userData['password'])){
    $userType = $userData['user_type'];

    echo json_encode([
        "title" => "Login Successfully",
        "message" => "You are logged as a $userType.",
        "status" => "success",
        "redirect" => $userType === 'Admin' ? "../../gym/dashboard/index.php" : "../../gym/dashboard/index.php"
    ]);
}else{
    echo json_encode([
        "title" => "Login Failed",
        "message" => "Invalid Username OR Password",
        "status" => "error"
    ]);
}
$stmt->close();
$conn->close();
?>
<?php
include 'db.php';
session_start();
$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    $stmt = $conn->prepare("UPDATE Shopper SET Name=?, Email=? WHERE ShopperId=?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile!";
    }
}
?>

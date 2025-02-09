<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $pwd_question = $_POST["pwd_question"];
    $pwd_answer = $_POST["pwd_answer"];

    // Ensure passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email exists
    $check_email = $conn->prepare("SELECT * FROM Shopper WHERE Email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        die("Email already registered.");
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO Shopper (Name, Email, Password, PwdQuestion, PwdAnswer) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $pwd_question, $pwd_answer);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

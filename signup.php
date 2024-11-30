<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'student_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $class = $_POST['class'];
    $section = $_POST['section'];
    $rollno = $_POST['rollno'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $photo = $_FILES['photo']['name'];

    $photo_target = 'uploads' . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target);

    $stmt = $conn->prepare("INSERT INTO students (fullname, username, password, class, section, rollno, subject, email, gender, address, phone, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisssssss", $fullname, $username, $password, $class, $section, $rollno, $subject, $email, $gender, $address, $phone, $photo);

    if ($stmt->execute()) {
        echo "Student registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

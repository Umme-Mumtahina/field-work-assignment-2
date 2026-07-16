<?php
include('../function.php');

session_start();
// collecting data from user input form
$btn = test_user($_POST['submit']);
$name = test_user($_POST['name']);
$email = test_user($_POST['email']);
$phone = test_user($_POST['phone']);
$experience = test_user($_POST['experience']);
$description = test_user($_POST['description']);
$project = test_user($_POST['project']);
$profile_image = $_FILES['profile_image'];

if(isset($btn)){
    // if(empty($name) || empty($email) || empty($phone) || empty($experience) || empty($description) || empty
    // ($project) || empty($profile_image)){
        // $_SESSION['error'] = "All fields are required";
        // header("Location: ../index.php");
        
}

// name validation
if (empty($name)) {
    $_SESSION['name_err'] = "Name is required";
    header("Location: ../index.php");
    exit();
} elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
    $_SESSION['name_err'] = "Only letters and white space allowed in name";
    header("Location: ../index.php");
    exit();
}
// email validation
if (empty($email)) {
    $_SESSION['email_err'] = "Email is required";
    header("Location: ../index.php");
    exit();
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_err'] = "Invalid email format";
    header("Location: ../index.php");
    exit();
}
//description validation
if (empty($description)) {
    $_SESSION['description_err'] = "Description is required";
    header("Location: ../index.php");
    exit();
}
// file handle
if(isset($_FILES['profile_image'])){

// empty check
if (empty($profile_image['name'])) {
    $_SESSION['profile_image_err'] = "Profile image is required";
    header("Location: ../index.php");
    exit();
}  
//extension check
$image_name = $profile_image['name'];
$file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'webp'];
if (!in_array($file_extension, $allowed)) {
    $_SESSION['profile_image_err'] = "Only JPG, JPEG, PNG, and WEBP files are allowed";
    header("Location: ../index.php");
    exit();
} 
}

// image
$image_location = $profile_image['tmp_name'];
$image_new_name = uniqid("user_") . '.' . $file_extension;
$image_url ="http://localhost/CURD_App/uploads/" . $image_new_name; // need to check the server path

// store data in database
include('../config/db.php');
$stmt = $conn->prepare("INSERT INTO users (name, email,  experience, description, project, image_name, image_url)
 VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $experience, $description, $project, $image_new_name, $image_url);
$insert = $stmt->execute();
if($insert){
    move_uploaded_file($image_location, '../uploads/' . $image_new_name);
    $_SESSION['success'] = "User added successfully";
    header("Location: ../index.php");
}
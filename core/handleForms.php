<?php  
require_once 'models.php';
require_once 'dbConfig.php';
require_once 'validate.php';

// User Registration
if (isset($_POST['registerUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $phone_number = sanitizeInput($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $bio = sanitizeInput($_POST['bio']);
    $date_of_birth = sanitizeInput($_POST['date_of_birth']);
    $gender = sanitizeInput($_POST['gender']);
    $address = sanitizeInput($_POST['address']);
    $city = sanitizeInput($_POST['city']);
    $state = sanitizeInput($_POST['state']);
    $country = sanitizeInput($_POST['country']);
    $postal_code = sanitizeInput($_POST['postal_code']);

    if ($password === $confirm_password && validatePassword($password)) {
        if (insertNewUser($pdo, $username, $first_name, $last_name, $email, $phone_number, sha1($password), $bio, $date_of_birth, $gender, $address, $city, $state, $country, $postal_code)) {
            header("Location: ../login.php");
        } else {
            $_SESSION['message'] = "User registration failed!";
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "Passwords do not match or do not meet criteria!";
        header("Location: ../register.php");
    }
}

// User Login
if (isset($_POST['loginUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sha1($_POST['password']);

    if (loginUser($pdo, $username, $password)) {
        header("Location: ../index.php");
    } else {
        $_SESSION['message'] = "Invalid login!";
        header("Location: ../login.php");
    }
}

// User Logout
if (isset($_GET['logoutAUser'])) {
    session_destroy();
    header('Location: ../login.php');
    exit();
}

// Insert New Post
if (isset($_POST['insertNewPostBtn'])) {
    $title = sanitizeInput($_POST['title']);
    $body = $_POST['body'];
    $status = $_POST['status'];
    $category = sanitizeInput($_POST['category']);
    $tags = sanitizeInput($_POST['tags']);
    $product_type = sanitizeInput($_POST['product_type']);
    $launch_date = sanitizeInput($_POST['launch_date']);
    $budget = sanitizeInput($_POST['budget']);
    $target_audience = sanitizeInput($_POST['target_audience']);
    $marketing_channels = sanitizeInput($_POST['marketing_channels']);
    $userID = $_SESSION['user_id']; 

    if (!empty($title) && !empty($body)) {
        if (insertNewPost($pdo, $title, $body, $userID, $userID, $status, $category, $tags, $product_type, $launch_date, $budget, $target_audience, $marketing_channels)) {
            header("Location: ../index.php");
        } else {
            $_SESSION['message'] = "Failed to add post!";
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['message'] = "Title and body cannot be empty!";
        header("Location: ../index.php");
    }
}

// Edit Post
if (isset($_POST['editPostBtn'])) {
    $title = sanitizeInput($_POST['title']);
    $body = sanitizeInput($_POST['body']);
    $status = $_POST['status'];
    $category = sanitizeInput($_POST['category']);
    $tags = sanitizeInput($_POST['tags']);
    $product_type = sanitizeInput($_POST['product_type']);
    $launch_date = sanitizeInput($_POST['launch_date']);
    $budget = sanitizeInput($_POST['budget']);
    $target_audience = sanitizeInput($_POST['target_audience']);
    $marketing_channels = sanitizeInput($_POST['marketing_channels']);
    $user_post_id = $_GET['user_post_id'];

    if (editAPost($pdo, $title, $body, $status, $category, $tags, $product_type, $launch_date, $budget, $target_audience, $marketing_channels, $user_post_id)) {
        header("Location: ../index.php");
    } else {
        $_SESSION['message'] = "Failed to edit post!";
        header("Location: ../index.php");
    }
}

// Delete Post
if (isset($_POST['deletePostBtn'])) {
    $user_post_id = $_GET['user_post_id'];

    if (deleteAPost($pdo, $user_post_id)) {
        header("Location: ../index.php");
    } else {
        $_SESSION['message'] = "Failed to delete post!";
        header("Location: ../index.php");
    }
}
?>
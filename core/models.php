<?php
require_once 'dbConfig.php';

function insertNewUser($pdo, $username, $first_name, $last_name, $email, $phone_number, $password, $bio, $date_of_birth, $gender, $address, $city, $state, $country, $postal_code) {
    $checkUserSql = "SELECT * FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($checkUserSql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 0) {
        $sql = "INSERT INTO user_accounts (username, first_name, last_name, email, phone_number, password, bio, date_of_birth, gender, address, city, state, country, postal_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$username, $first_name, $last_name, $email, $phone_number, $password, $bio, $date_of_birth, $gender, $address, $city, $state, $country, $postal_code]);
    } else {
        $_SESSION['message'] = "User already exists";
        return false;
    }
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM user_accounts WHERE username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        if ($password == $userInfoRow['password']) {
            $_SESSION['user_id'] = $userInfoRow['user_id'];
            $_SESSION['username'] = $userInfoRow['username'];
            updateLastLogin($pdo, $userInfoRow['user_id']);
            return true;
        }
    }
    $_SESSION['message'] = "Invalid username or password";
    return false;
}

function updateLastLogin($pdo, $user_id) {
    $sql = "UPDATE user_accounts SET last_login = NOW() WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
}

function insertNewPost($pdo, $title, $body, $user_id, $added_by, $status, $category, $tags, $product_type, $launch_date, $budget, $target_audience, $marketing_channels) {
    $sql = "INSERT INTO user_posts (title, body, user_id, added_by, status, category, tags, product_type, launch_date, budget, target_audience, marketing_channels) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$title, $body, $user_id, $added_by, $status, $category, $tags, $product_type, $launch_date, $budget, $target_audience, $marketing_channels]);
}

function editAPost($pdo, $title, $body, $status, $category, $tags, $product_type, $launch_date, $budget, $target_audience, $marketing_channels, $user_post_id) {
    $sql = "UPDATE user_posts SET title = ?, body = ?, status = ?, category = ?, tags = ?, product_type = ?, launch_date = ?, budget = ?, target_audience = ?, marketing_channels = ?, last_updated = NOW() WHERE user_post_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$title, $body, $status, $category, $tags, $product_type, $launch_date, $budget, $target_audience, $marketing_channels, $user_post_id]);
}

function deleteAPost($pdo, $user_post_id) {
    $sql = "DELETE FROM user_posts WHERE user_post_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_post_id]);
}

function getAllPosts($pdo) {
    $sql = "SELECT
                user_posts.user_post_id AS user_post_id,
                user_posts.user_id AS user_id,
                user_posts.added_by AS added_by,
                CONCAT(user_accounts.first_name, ' ', user_accounts.last_name) AS userFullName,
                user_posts.title AS title,
                user_posts.body AS body,
                user_posts.date_added AS date_added,
                user_posts.last_updated AS last_updated,
                user_posts.status AS status,
                user_posts.views AS views,
                user_posts.category AS category,
                user_posts.tags AS tags,
                user_posts.product_type AS product_type,
                user_posts.launch_date AS launch_date,
                user_posts.budget AS budget,
                user_posts.target_audience AS target_audience,
                user_posts.marketing_channels AS marketing_channels
            FROM user_posts
            JOIN user_accounts ON user_posts.user_id = user_accounts.user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_accounts";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUserByID($pdo, $user_id) {
    $sql = "SELECT * FROM user_accounts WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

function getPostByID($pdo, $user_post_id) {
    $sql = "SELECT * FROM user_posts WHERE user_post_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_post_id]);
    return $stmt->fetch();
}

function getAllPostsByUser($pdo, $user_id) {
    $sql = "SELECT * FROM user_posts WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function incrementPostViews($pdo, $user_post_id) {
    $sql = "UPDATE user_posts SET views = views + 1 WHERE user_post_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_post_id]);
}
?>
<?php 
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background-color: #f8f0f8; 
        }
        .stroke-text {
            color: #000; 
            text-shadow: 
                1px 1px 0 #fff,
                -1px -1px 0 #fff,
                1px -1px 0 #fff,
                -1px 1px 0 #fff; 
            font-size: 2rem; 
        }
    </style>
</head>
<body class="index-page">
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h1 class="stroke-text">𐙚💌👄💆🏻‍♀️🧴💅🏻🧼🫧Create A Project💗🌸👝🛒💮🌷🌺𐙚</h1>
        <form action="core/handleForms.php" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" name="body" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" name="category" required>
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" class="form-control" name="tags" required>
            </div>
            <div class="form-group">
                <label for="product_type">Product Type</label>
                <select class="form-control" name="product_type">
                    <option value="skincare">Skincare</option>
                    <option value="makeup">Makeup</option>
                    <option value="tools">Tools</option>
                    <option value="supplement">Supplement</option>
                </select>
            </div>
            <div class="form-group">
                <label for="launch_date">Launch Date</label>
                <input type="date" class="form-control" name="launch_date">
            </div>
            <div class="form-group">
                <label for="budget">Budget</label>
                <input type="number" class="form-control" name="budget" step="0.01">
            </div>
            <div class="form-group">
                <label for="target_audience">Target Audience</label>
                <input type="text" class="form-control" name="target_audience">
            </div>
            <div class="form-group">
                <label for="marketing_channels">Marketing Channels</label>
                <input type="text" class="form-control" name="marketing_channels">
            </div>
            <button type="submit" name="insertNewPostBtn" class="btn">Submit</button>
        </form>

        <h1 class="stroke-text">𐙚💌👄💆🏻‍♀️🧴💅🏻🧼🫧All Projects💗🌸👝🛒💮🌷🌺𐙚</h1>
        <?php $getAllPosts = getAllPosts($pdo); ?>
        <?php foreach ($getAllPosts as $row) { ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                    Added By: <?php echo $row['userFullName']; ?> - 
                        <?php echo $row['date_added']; ?> 
                        (Status: <?php echo $row['status']; ?>, Views: <?php echo $row['views']; ?>)
                    </h6>
                    <p class="card-text"><?php echo $row['body']; ?></p>
                    <p class="card-text"><small>Last updated: <?php echo $row['last_updated']; ?></small></p>
                    <p class="card-text"><small>Category: <?php echo $row['category']; ?></small></p>
                    <p class="card-text"><small>Tags: <?php echo $row['tags']; ?></small></p>
                    <p class="card-text"><small>Product Type: <?php echo $row['product_type']; ?></small></p>
                    <p class="card-text"><small>Launch Date: <?php echo $row['launch_date']; ?></small></p>
                    <p class="card-text"><small>Budget: <?php echo $row['budget']; ?></small></p>
                    <p class="card-text"><small>Target Audience: <?php echo $row['target_audience']; ?></small></p>
                    <p class="card-text"><small>Marketing Channels: <?php echo $row['marketing_channels']; ?></small></p>
                    <?php if ($_SESSION['user_id'] == $row['user_id']) { ?>
                        <a href="editAProject.php?user_post_id=<?php echo $row['user_post_id']; ?>" class="card-link">Edit</a>
                        <a href="deleteAProject.php?user_post_id=<?php echo $row['user_post_id']; ?>" class="card-link">Delete</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>

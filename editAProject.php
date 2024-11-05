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
    <title>Edit Project</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #f8f0f8; }
        .btn-pink {
            background-color: #d63384; /* Bootstrap's pink color */
            border-color: #d63384;
            color: white; /* Text color */
        }
        .btn-pink:hover {
            background-color: #c82391; /* Darker pink on hover */
            border-color: #bd2130; /* Darker border color on hover */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <?php $getPostByID = getPostByID($pdo, $_GET['user_post_id']); ?>
        <h2>Edit Project</h2>
        <form action="core/handleForms.php?user_post_id=<?php echo $_GET['user_post_id']; ?>" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $getPostByID['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" name="body" rows="5" required><?php echo $getPostByID['body']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" required>
                    <option value="draft" <?php echo ($getPostByID['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?php echo ($getPostByID['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" name="category" value="<?php echo $getPostByID['category']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" class="form-control" name="tags" value="<?php echo $getPostByID['tags']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_type">Product Type</label>
                <select class="form-control" name="product_type" required>
                    <option value="skincare" <?php echo ($getPostByID['product_type'] == 'skincare') ? 'selected' : ''; ?>>Skincare</option>
                    <option value="makeup" <?php echo ($getPostByID['product_type'] == 'makeup') ? 'selected' : ''; ?>>Makeup</option>
                    <option value="tools" <?php echo ($getPostByID['product_type'] == 'tools') ? 'selected' : ''; ?>>Tools</option>
                    <option value="supplement" <?php echo ($getPostByID['product_type'] == 'supplement') ? 'selected' : ''; ?>>Supplement</option>
                </select>
            </div>
            <div class="form-group">
                <label for="launch_date">Launch Date</label>
                <input type="date" class="form-control" name="launch_date" value="<?php echo $getPostByID['launch_date']; ?>">
            </div>
            <div class="form-group">
                <label for="budget">Budget</label>
                <input type="number" class="form-control" name="budget" value="<?php echo $getPostByID['budget']; ?>" step="0.01">
            </div>
            <div class="form-group">
                <label for="target_audience">Target Audience</label>
                <input type="text" class="form-control" name="target_audience" value="<?php echo $getPostByID['target_audience']; ?>">
            </div>
            <div class="form-group">
                <label for="marketing_channels">Marketing Channels</label>
                <input type="text" class="form-control" name="marketing_channels" value="<?php echo $getPostByID['marketing_channels']; ?>">
            </div>
            <button type="submit" name="editPostBtn" class="btn btn-pink">Update</button>
        </form>
    </div>
</body>
</html>
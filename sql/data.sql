CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100),
    phone_number VARCHAR(15),
    password VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    profile_picture VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    bio TEXT,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    address VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    country VARCHAR(100),
    postal_code VARCHAR(10)
);


CREATE TABLE user_posts (
    user_post_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    body TEXT,
    user_id INT,
    added_by INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('draft', 'published') DEFAULT 'draft',
    views INT DEFAULT 0,
    category VARCHAR(50),
    tags VARCHAR(255),
    product_type ENUM('skincare', 'makeup', 'tools', 'supplement') DEFAULT 'makeup',
    launch_date DATE,
    budget DECIMAL(10, 2),
    target_audience VARCHAR(255),
    marketing_channels VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES user_accounts(user_id)
);
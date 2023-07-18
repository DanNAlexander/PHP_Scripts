<?php
// Database configuration
define('DB_HOST', 'your_database_host');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');
define('DB_NAME', 'your_database_name');

// Establish database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>


<!------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------>


<?php
require_once 'config.php';

try {
    // Create the 'users' table
    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL
            )";

    $pdo->exec($sql);

    // Add sample data
    $sampleUsers = [
        ['username' => 'user1', 'password' => password_hash('password1', PASSWORD_DEFAULT)],
        ['username' => 'user2', 'password' => password_hash('password2', PASSWORD_DEFAULT)],
        // Add more sample users here...
    ];

    $insertSql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($insertSql);

    foreach ($sampleUsers as $user) {
        $stmt->execute($user);
    }

    echo "Database setup and sample data inserted successfully.";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>


<!------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------>


<!-- registration.php -->
<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);

        echo "Registration successful.";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h1>User Registration</h1>
    <form method="post" action="registration.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>

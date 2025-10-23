<?php
require_once __DIR__ . '/config.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = 'Email already registered!';
    } else {
        mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
        header("Location: login.php?msg=" . urlencode('Registration successful. Please log in.'));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<!-- Background Animations -->
<div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>

<div class="container">
<h2>Register</h2>
<?php if (!empty($error)) { echo '<div class="alert alert-error">' . htmlspecialchars($error) . '</div>'; } ?>
<form method="POST">
    <label for="name">Name</label>
    <input id="name" type="text" name="name" required>
    <br><br>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" required>
    <br><br>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <br><br>
    <input type="submit" value="Register">
    <p><a href="login.php">Have an account? Login</a></p>
</form>
</div>
</body>
</html>

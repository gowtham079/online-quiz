<?php
session_start();
require_once __DIR__ . '/config.php';
$conn = db_connect();

$error = '';
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = (string)$_POST['password'];

    $safeEmail = mysqli_real_escape_string($conn, $email);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$safeEmail'");
    $user = $result ? mysqli_fetch_assoc($result) : null;

    if (!$user) {
        $error = 'No account found for this email. Please register.';
    }

    if (!$error && !password_verify($password, $user['password'])) {
        $error = 'Incorrect password. Please try again.';
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        if (is_admin()) {
            header("Location: admin.php");
        } else {
            header("Location: quiz.php");
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
<h2>Login</h2>
<?php if (!empty($msg)) { echo '<div class="alert alert-success">' . htmlspecialchars($msg) . '</div>'; } ?>
<?php if (!empty($error)) { echo '<div class="alert alert-error">' . htmlspecialchars($error) . '</div>'; } ?>
<form method="POST">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" required>
    <br><br>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <br><br>
    <input type="submit" value="Login">
    <p><a href="register.php">Create an account</a></p>
  </form>
</div>
</body>
</html>

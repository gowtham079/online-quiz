<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['score'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Quiz Result</title><link rel="stylesheet" href="style.css?v=<?php echo time(); ?>"></head>
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
<h2>Your Score: <?php echo $_SESSION['score']; ?><?php if (isset($_SESSION['total_questions'])) { echo ' / ' . $_SESSION['total_questions']; } ?></h2>
<?php if (isset($_SESSION['email_sent'])) { ?>
<p>Email status: <?php echo $_SESSION['email_sent'] === 'yes' ? 'Sent to ' . htmlspecialchars($_SESSION['user_email']) : 'Not sent'; ?></p>
<?php } ?>
<p><a href="quiz.php">Start New Quiz</a> | <a href="logout.php">Logout</a></p>
</div>
</body>
</html>

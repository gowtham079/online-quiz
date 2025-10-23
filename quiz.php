<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/config.php';
$conn = db_connect();

// Handle navigation
$current_question = isset($_GET['q']) ? (int)$_GET['q'] : 1;
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Clear answers if starting fresh
if ($current_question == 1 && !isset($_GET['continue'])) {
    unset($_SESSION['answers']);
}

// Get total questions
$total_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM questions");
$total_row = $total_res ? mysqli_fetch_assoc($total_res) : ['total' => 0];
$total_questions = (int)$total_row['total'];

// Validate current question
if ($current_question < 1) $current_question = 1;
if ($current_question > $total_questions) $current_question = $total_questions;

// Handle answer saving
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    $question_id = (int)$_POST['question_id'];
    $answer = $_POST['answer'];
    
    // Save answer to session
    if (!isset($_SESSION['answers'])) {
        $_SESSION['answers'] = [];
    }
    $_SESSION['answers'][$question_id] = $answer;
    
    // Redirect to next question or show completion
    if ($current_question < $total_questions) {
        header("Location: quiz.php?q=" . ($current_question + 1));
        exit();
    } else {
        // All questions answered, redirect to submit
        header("Location: submit.php");
        exit();
    }
}

// Get current question
$question_query = mysqli_query($conn, "SELECT * FROM questions LIMIT 1 OFFSET " . ($current_question - 1));
$question = $question_query ? mysqli_fetch_assoc($question_query) : null;

if (!$question) {
    header("Location: login.php");
    exit();
}

// Count answered questions
$answered_count = isset($_SESSION['answers']) ? count($_SESSION['answers']) : 0;
$min_required = min(10, $total_questions);
$can_submit = $answered_count >= $min_required;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
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
    <h2>⚡ Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>. Start your quiz! ⚡</h2>
    
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php } ?>
    
    <!-- Progress Bar -->
    <div class="progress-container">
        <div class="progress-bar" style="width: <?php echo ($answered_count / $total_questions) * 100; ?>%"></div>
    </div>
    
    <!-- Question Counter -->
    <div style="text-align: center; margin: 15px 0; font-family: 'Orbitron', monospace; font-size: 16px;">
        <span>Question <?php echo $current_question; ?> of <?php echo $total_questions; ?></span>
        <br>
        <span style="font-size: 14px; color: rgba(255,255,255,0.7);">Answered: <?php echo $answered_count; ?>/<?php echo $total_questions; ?> (Minimum: <?php echo $min_required; ?>)</span>
    </div>
    
    <!-- Current Question -->
    <form method="POST" action="quiz.php?q=<?php echo $current_question; ?>">
        <div class="quiz-question floating">
            <p><b>Q<?php echo $current_question; ?>: <?php echo htmlspecialchars($question['question']); ?></b></p>
            
            <label>
                <input type="radio" name="answer" value="A" <?php echo (isset($_SESSION['answers'][$question['id']]) && $_SESSION['answers'][$question['id']] == 'A') ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($question['option_a']); ?>
            </label><br>
            
            <label>
                <input type="radio" name="answer" value="B" <?php echo (isset($_SESSION['answers'][$question['id']]) && $_SESSION['answers'][$question['id']] == 'B') ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($question['option_b']); ?>
            </label><br>
            
            <label>
                <input type="radio" name="answer" value="C" <?php echo (isset($_SESSION['answers'][$question['id']]) && $_SESSION['answers'][$question['id']] == 'C') ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($question['option_c']); ?>
            </label><br>
            
            <label>
                <input type="radio" name="answer" value="D" <?php echo (isset($_SESSION['answers'][$question['id']]) && $_SESSION['answers'][$question['id']] == 'D') ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($question['option_d']); ?>
            </label><br>
        </div>
        
        <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
        
        <div class="quiz-nav">
            <?php if ($current_question > 1): ?>
                <a href="quiz.php?q=<?php echo $current_question - 1; ?>" class="quiz-nav-btn">← Previous</a>
            <?php else: ?>
                <span class="quiz-nav-btn disabled">← Previous</span>
            <?php endif; ?>
            
            <?php if ($current_question < $total_questions): ?>
                <button type="submit" class="quiz-nav-btn">Next →</button>
            <?php else: ?>
                <button type="submit" class="quiz-nav-btn">Finish Quiz ⚡</button>
            <?php endif; ?>
            
            <?php if ($can_submit): ?>
                <a href="submit.php" class="quiz-nav-btn submit-btn">Submit Quiz ⚡</a>
            <?php endif; ?>
        </div>
    </form>
    
    <p><a href='logout.php'>Logout</a></p>
</div>

</body>
</html>

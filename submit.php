<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/config.php';
$conn = db_connect();

// Get answers from session
$user_answers = isset($_SESSION['answers']) ? $_SESSION['answers'] : [];
$score = 0;

// Validate minimum questions answered
$min_required = 10;
$totalRes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM questions");
$totalRow = $totalRes ? mysqli_fetch_assoc($totalRes) : [ 'total' => 0 ];
$total_q = (int)$totalRow['total'];
$min_required = min($min_required, $total_q); // Don't require more than total questions

if (count($user_answers) < $min_required) {
    $_SESSION['error'] = "You must answer at least $min_required questions to submit the quiz!";
    header("Location: quiz.php?q=1");
    exit();
}

foreach ($user_answers as $question_id => $answer) {
    $qid = (int)$question_id;
    $q = mysqli_query($conn, "SELECT correct_answer, option_a, option_b, option_c, option_d FROM questions WHERE id = $qid");
    if ($q && ($row = mysqli_fetch_assoc($q))) {
        $correctRaw = trim((string)$row['correct_answer']);
        $userRaw = trim((string)$answer);

        $map = [
            'A' => trim((string)$row['option_a']),
            'B' => trim((string)$row['option_b']),
            'C' => trim((string)$row['option_c']),
            'D' => trim((string)$row['option_d']),
        ];

        $resolveToLetter = function ($value) use ($map) {
            $v = strtoupper(trim((string)$value));
            if (isset($map[$v])) {
                return $v; // Already a letter A-D
            }
            foreach ($map as $letter => $text) {
                if ($v === strtoupper(trim((string)$text))) {
                    return $letter;
                }
            }
            return null;
        };

        $correctLetter = $resolveToLetter($correctRaw);
        $userLetter = $resolveToLetter($userRaw);

        if ($correctLetter !== null && $userLetter !== null && $userLetter === $correctLetter) {
            $score++;
        }
    }
}
$_SESSION['score'] = $score;
$_SESSION['total_questions'] = $total_q;

// Persist attempt: create table if not exists and insert
$createAttemptsSql = "CREATE TABLE IF NOT EXISTS attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($conn, $createAttemptsSql);

$uid = (int)$_SESSION['user_id'];
$scoreVal = (int)$score;
$totalVal = (int)$total_q;
mysqli_query($conn, "INSERT INTO attempts (user_id, score, total_questions) VALUES ($uid, $scoreVal, $totalVal)");

// Email the result to the attendee
require_once __DIR__ . '/mail.php';
$emailSent = false;
if (!empty($_SESSION['user_email']) && !empty($_SESSION['user_name'])) {
    $emailSent = sendResultEmail($_SESSION['user_email'], $_SESSION['user_name'], $score, $total_q);
}
$_SESSION['email_sent'] = $emailSent ? 'yes' : 'no';
header("Location: result.php");
?>

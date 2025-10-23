
<?php
session_start();
require_once __DIR__ . '/config.php';
$conn = db_connect();

if (!isset($_SESSION['user_id']) || !is_admin()) {
    header('Location: login.php');
    exit();
}

// Handle delete user (admin cannot delete own admin account by email)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $deleteId = (int)$_POST['delete_user_id'];
    $check = mysqli_query($conn, "SELECT email FROM users WHERE id = $deleteId");
    $row = $check ? mysqli_fetch_assoc($check) : null;
    if ($row && strtolower($row['email']) !== strtolower($ADMIN_EMAIL)) {
        mysqli_query($conn, "DELETE FROM attempts WHERE user_id = $deleteId");
        mysqli_query($conn, "DELETE FROM users WHERE id = $deleteId");
    }
    header('Location: admin.php');
    exit();
}

// Ensure attempts table exists
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Fetch users with stats: total attempts and latest score
$sql = "SELECT u.id, u.name, u.email,
        COUNT(a.id) AS attempts_count,
        (SELECT CONCAT(a2.score, '/', a2.total_questions)
           FROM attempts a2
          WHERE a2.user_id = u.id
          ORDER BY a2.created_at DESC, a2.id DESC
          LIMIT 1) AS latest_score
        FROM users u
        LEFT JOIN attempts a ON a.user_id = u.id
        GROUP BY u.id, u.name, u.email
        ORDER BY u.id ASC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>&r=<?php echo rand(1000,9999); ?>">
    <style>
        /* Fallback styles to ensure immediate visibility */
        .admin-dashboard {
            max-width: 800px !important;
            margin: 5vh auto !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 32px !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.04) !important;
        }
        .admin-dashboard h2 {
            font-size: 28px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin: 0 0 8px 0 !important;
        }
        .admin-dashboard h3 {
            font-size: 18px !important;
            font-weight: 500 !important;
            color: #6b7280 !important;
            margin: 0 0 24px 0 !important;
        }
        .admin-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 24px !important;
            background: #ffffff !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
        .admin-table th {
            background: #f8fafc !important;
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 16px 12px !important;
            text-align: left !important;
            border-bottom: 1px solid #e5e7eb !important;
        }
        .admin-table td {
            padding: 16px 12px !important;
            border-bottom: 1px solid #f3f4f6 !important;
            font-size: 14px !important;
            color: #374151 !important;
        }
        .admin-table tr:last-child td {
            border-bottom: none !important;
        }
        .admin-table tr:hover {
            background: #f9fafb !important;
        }
        .admin-badge {
            display: inline-block !important;
            margin-left: 8px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6b7280 !important;
            background: #f3f4f6 !important;
            border: 1px solid #d1d5db !important;
            padding: 2px 8px !important;
            border-radius: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
        }
        .admin-badge.admin {
            background: #dbeafe !important;
            color: #1e40af !important;
            border-color: #bfdbfe !important;
        }
        .delete-btn {
            background: #dc2626 !important;
            color: #ffffff !important;
            border: none !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: background-color 0.2s !important;
        }
        .delete-btn:hover {
            background: #b91c1c !important;
        }
        .logout-link {
            color: #2563eb !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            font-size: 14px !important;
        }
        .logout-link:hover {
            text-decoration: underline !important;
        }
    </style>
</head>
<body>
<div class="admin-dashboard">
    <h2>Admin Dashboard</h2>
    <h3>Users and Scores</h3>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Attempts</th>
                <th>Latest Score</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($res): ?>
                <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td><?php echo (int)$row['id']; ?></td>
                        <td>
                            <?php echo htmlspecialchars($row['name']); ?>
                            <?php $isAdminUser = strtolower($row['email']) === strtolower($ADMIN_EMAIL); ?>
                            <span class="admin-badge <?php echo $isAdminUser ? 'admin' : ''; ?>">
                                <?php echo $isAdminUser ? 'Admin' : 'User'; ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo (int)$row['attempts_count']; ?></td>
                        <td><?php echo $row['latest_score'] ? htmlspecialchars($row['latest_score']) : '—'; ?></td>
                        <td>
                            <?php if (strtolower($row['email']) !== strtolower($ADMIN_EMAIL)) { ?>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this user and all attempts?');">
                                    <input type="hidden" name="delete_user_id" value="<?php echo (int)$row['id']; ?>">
                                    <input type="submit" value="Delete" class="delete-btn">
                                </form>
                            <?php } else { ?>
                                —
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="no-data">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p><a href="logout.php" class="logout-link">Logout</a></p>
</div>
</body>
</html>



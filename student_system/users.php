<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $new_username  = trim($_POST['new_username']);
    $new_fullname  = trim($_POST['new_fullname']);
    $new_password  = trim($_POST['new_password']);
    $new_role      = $_POST['new_role'];

    if (empty($new_username) || empty($new_fullname) || empty($new_password)) {
        $error = "All fields are required.";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, full_name, role) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $new_username, $hashed, $new_fullname, $new_role);
        if (mysqli_stmt_execute($stmt)) {
            $success = "User '{$new_username}' created successfully.";
        } else {
            $error = "Username already exists or an error occurred.";
        }
    }
}


if (isset($_GET['delete_user'])) {
    $del_id = (int)$_GET['delete_user'];
    if ($del_id === $_SESSION['user_id']) {
        $error = "You cannot delete your own account.";
    } else {
        mysqli_query($conn, "DELETE FROM users WHERE id = $del_id");
        $success = "User deleted successfully.";
    }
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management – School SIMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="section-title">👥 User Management</h2>
    <p style="color:#666; margin-bottom:20px; font-size:0.9rem;">Manage system users. Only administrators can access this page.</p>

    <?php if ($success): ?>
        <div class="alert alert-success">✅ <?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error">❌ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="form-box">
        <h3 style="margin-bottom:18px; font-size:1.1rem; color:#1a6b3c;">➕ Add New User</h3>
        <form method="POST" action="users.php">
            <input type="hidden" name="action" value="add_user">
            <div class="form-grid">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="new_username" placeholder="e.g. teacher01" required>
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="new_fullname" placeholder="Full name" required>
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="new_password" placeholder="At least 6 characters" required>
                </div>
                <div class="form-group">
                    <label>Role *</label>
                    <select name="new_role" required>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:18px;">➕ Add User</button>
        </form>
    </div>

    <div class="table-box">
        <h3 style="margin-bottom:15px; font-size:1.1rem; color:#1a6b3c;">📋 Registered System Users</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Registered On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; while ($u = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><strong><?php echo htmlspecialchars($u['username']); ?></strong></td>
                    <td><?php echo htmlspecialchars($u['full_name']); ?></td>
                    <td>
                        <span class="badge <?php echo $u['role'] === 'admin' ? 'badge-secondary' : 'badge-primary'; ?>">
                            <?php echo ucfirst($u['role']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                    <td>
                        <?php if ($u['id'] !== $_SESSION['user_id']): ?>
                        <a href="users.php?delete_user=<?php echo $u['id']; ?>" class="btn btn-danger"
                           style="font-size:0.8rem; padding:5px 10px;"
                           onclick="return confirm('Delete user <?php echo htmlspecialchars($u['username']); ?>?')">🗑 Delete</a>
                        <?php else: ?>
                            <em style="color:#aaa; font-size:0.85rem;">Current User</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> School SIMS – CP 222 Open Source Technologies | University of Dodoma
</footer>
</body>
</html>

<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';
$success = '';
$error   = '';
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if (mysqli_query($conn, "DELETE FROM students WHERE id = $del_id")) {
        $success = "Student record deleted successfully.";
    } else {
        $error = "Could not delete the record. Please try again.";
    }
}
$level_filter = isset($_GET['level']) ? $_GET['level'] : '';
$where = '';
if ($level_filter === 'Primary' || $level_filter === 'Secondary') {
    $safe = mysqli_real_escape_string($conn, $level_filter);
    $where = "WHERE school_level = '$safe'";
}

$students = mysqli_query($conn, "SELECT * FROM students $where ORDER BY registered_at DESC");
$count = mysqli_num_rows($students);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students – School SIMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="section-title">📋 Student Records</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">✅ <?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error">❌ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
        <div style="display:flex; gap:8px;">
            <a href="students.php" class="btn btn-secondary <?php echo !$level_filter ? 'active' : ''; ?>">All (<?php echo mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM students"))[0]; ?>)</a>
            <a href="students.php?level=Primary"   class="btn btn-secondary">Primary</a>
            <a href="students.php?level=Secondary" class="btn btn-secondary">Secondary</a>
        </div>
        <a href="register.php" class="btn btn-primary">+ Register New Student</a>
    </div>

    <div class="table-box">
        <?php if ($count > 0): ?>
        <p style="margin-bottom:12px; color:#555; font-size:0.9rem;">Showing <strong><?php echo $count; ?></strong> student(s)<?php echo $level_filter ? " – {$level_filter} Level" : ''; ?>.</p>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reg. Number</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Level</th>
                    <th>Class</th>
                    <th>Region</th>
                    <th>Parent Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; while ($s = mysqli_fetch_assoc($students)): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><strong><?php echo htmlspecialchars($s['reg_number']); ?></strong></td>
                    <td><?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?></td>
                    <td><?php echo $s['gender'] === 'Male' ? '👦' : '👧'; ?> <?php echo $s['gender']; ?></td>
                    <td>
                        <span class="badge <?php echo $s['school_level'] === 'Primary' ? 'badge-primary' : 'badge-secondary'; ?>">
                            <?php echo $s['school_level']; ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($s['class_grade']); ?></td>
                    <td><?php echo htmlspecialchars($s['region']); ?></td>
                    <td><?php echo htmlspecialchars($s['parent_phone']); ?></td>
                    <td>
                        <a href="view_student.php?id=<?php echo $s['id']; ?>" class="btn btn-secondary" style="font-size:0.8rem; padding:5px 10px;">👁 View</a>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="students.php?delete=<?php echo $s['id']; ?>" class="btn btn-danger" style="font-size:0.8rem; padding:5px 10px;"
                           onclick="return confirm('Are you sure you want to delete this student record?')">🗑 Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>No student records found<?php echo $level_filter ? " for {$level_filter} level" : ''; ?>.</p>
            <a href="register.php" class="btn btn-primary" style="margin-top:15px;">+ Register First Student</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> School SIMS – CP 222 Open Source Technologies | University of Dodoma
</footer>
</body>
</html>

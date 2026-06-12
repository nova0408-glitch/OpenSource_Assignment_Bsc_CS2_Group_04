<?php
// Shared navigation bar
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="navbar">
    <div class="brand">
        🏫 School SIMS
        <span>Student Information Management System</span>
    </div>
    <nav>
        <a href="index.php"     class="<?php echo $current_page === 'index.php'    ? 'active' : ''; ?>">📊 Dashboard</a>
        <a href="register.php"  class="<?php echo $current_page === 'register.php' ? 'active' : ''; ?>">📝 Register</a>
        <a href="students.php"  class="<?php echo $current_page === 'students.php' ? 'active' : ''; ?>">📋 Students</a>
        <a href="search.php"    class="<?php echo $current_page === 'search.php'   ? 'active' : ''; ?>">🔍 Search</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="users.php"     class="<?php echo $current_page === 'users.php'    ? 'active' : ''; ?>">👥 Users</a>
        <?php endif; ?>
        <a href="logout.php" class="logout-btn">🚪 Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
    </nav>
</div>

<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';

// Fetch summary stats
$total_students   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM students"))[0];
$primary_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM students WHERE school_level='Primary'"))[0];
$secondary_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM students WHERE school_level='Secondary'"))[0];
$total_regions    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(DISTINCT region) FROM students"))[0];

// Fetch last 5 registered students
$recent = mysqli_query($conn, "SELECT * FROM students ORDER BY registered_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – School SIMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="section-title">📊 Dashboard</h2>

    <!-- Summary Cards -->
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-icon">👩‍🎓</div>
            <div class="card-number"><?php echo $total_students; ?></div>
            <div class="card-label">Total Students</div>
        </div>
        <div class="card">
            <div class="card-icon">🏫</div>
            <div class="card-number"><?php echo $primary_students; ?></div>
            <div class="card-label">Primary School</div>
        </div>
        <div class="card">
            <div class="card-icon">🎓</div>
            <div class="card-number"><?php echo $secondary_students; ?></div>
            <div class="card-label">Secondary School</div>
        </div>
        <div class="card">
            <div class="card-icon">📍</div>
            <div class="card-number"><?php echo $total_regions; ?></div>
            <div class="card-label">Regions Covered</div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="table-box">
        <h3 class="section-title">🕐 Recently Registered Students</h3>
        <?php if (mysqli_num_rows($recent) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Reg. Number</th>
                    <th>Full Name</th>
                    <th>Level</th>
                    <th>Class / Grade</th>
                    <th>Region</th>
                    <th>Registered On</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($s = mysqli_fetch_assoc($recent)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($s['reg_number']); ?></strong></td>
                    <td><?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?></td>
                    <td>
                        <span class="badge <?php echo $s['school_level'] === 'Primary' ? 'badge-primary' : 'badge-secondary'; ?>">
                            <?php echo $s['school_level']; ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($s['class_grade']); ?></td>
                    <td><?php echo htmlspecialchars($s['region']); ?></td>
                    <td><?php echo date('d M Y', strtotime($s['registered_at'])); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>No students registered yet. <a href="register.php">Register the first student</a>.</p>
        </div>
        <?php endif; ?>
    </div>

    <div style="text-align:right; margin-top:15px;">
        <a href="students.php" class="btn btn-secondary">View All Students →</a>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> School SIMS – CP 222 Open Source Technologies | University of Dodoma
</footer>
</body>
</html>

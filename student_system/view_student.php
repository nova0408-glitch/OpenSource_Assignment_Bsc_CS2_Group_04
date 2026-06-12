<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
$s = mysqli_fetch_assoc($result);

if (!$s) {
    echo "<p style='padding:30px; color:red;'>Student not found. <a href='students.php'>Go back</a>.</p>";
    exit();
}

$age = date_diff(date_create($s['date_of_birth']), date_create('today'))->y;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($s['first_name']); ?> – School SIMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="section-title">👁 Student Profile</h2>

    <div class="form-box">
        <div style="display:flex; gap:30px; flex-wrap:wrap; align-items:flex-start;">
            <!-- Avatar -->
            <div style="text-align:center; min-width:140px;">
                <div style="font-size:5rem; background:#e8f5ef; width:120px; height:120px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                    <?php echo $s['gender'] === 'Male' ? '👦' : '👧'; ?>
                </div>
                <div style="margin-top:12px;">
                    <span class="badge <?php echo $s['school_level'] === 'Primary' ? 'badge-primary' : 'badge-secondary'; ?>" style="font-size:0.9rem; padding:5px 14px;">
                        <?php echo $s['school_level']; ?> School
                    </span>
                </div>
            </div>

            <!-- Details -->
            <div style="flex:1; min-width:280px;">
                <h2 style="color:#1a6b3c; font-size:1.6rem; margin-bottom:6px;">
                    <?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?>
                </h2>
                <p style="color:#888; font-size:0.95rem; margin-bottom:20px;">
                    📋 Reg. No: <strong><?php echo htmlspecialchars($s['reg_number']); ?></strong>
                </p>

                <div class="form-grid" style="gap:12px;">
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Gender</p>
                        <p style="font-size:1rem; color:#333;"><?php echo $s['gender']; ?></p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Date of Birth</p>
                        <p style="font-size:1rem; color:#333;"><?php echo date('d M Y', strtotime($s['date_of_birth'])); ?> (Age <?php echo $age; ?>)</p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Class / Grade</p>
                        <p style="font-size:1rem; color:#333;"><?php echo htmlspecialchars($s['class_grade']); ?></p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Region</p>
                        <p style="font-size:1rem; color:#333;">📍 <?php echo htmlspecialchars($s['region']); ?></p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Parent / Guardian</p>
                        <p style="font-size:1rem; color:#333;"><?php echo htmlspecialchars($s['parent_name']); ?></p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Parent Phone</p>
                        <p style="font-size:1rem; color:#333;">📞 <?php echo htmlspecialchars($s['parent_phone']); ?></p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem; color:#888; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Registered On</p>
                        <p style="font-size:1rem; color:#333;"><?php echo date('d M Y, H:i', strtotime($s['registered_at'])); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top:25px; display:flex; gap:12px;">
            <a href="students.php" class="btn btn-secondary">← Back to All Students</a>
            <a href="search.php" class="btn btn-secondary">🔍 Search Again</a>
        </div>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> School SIMS – CP 222 Open Source Technologies | University of Dodoma
</footer>
</body>
</html>

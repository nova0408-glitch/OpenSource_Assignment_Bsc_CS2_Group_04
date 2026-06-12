<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $reg_number   = strtoupper(trim($_POST['reg_number']));
    $first_name   = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $gender       = $_POST['gender'];
    $dob          = $_POST['date_of_birth'];
    $level        = $_POST['school_level'];
    $grade        = trim($_POST['class_grade']);
    $region       = trim($_POST['region']);
    $parent_name  = trim($_POST['parent_name']);
    $parent_phone = trim($_POST['parent_phone']);

    // Basic validation
    if (empty($reg_number) || empty($first_name) || empty($last_name) || empty($dob) || empty($grade) || empty($region) || empty($parent_name) || empty($parent_phone)) {
        $error = "All fields are required. Please fill in every field.";
    } else {
        // Check if reg number already exists
        $check = mysqli_prepare($conn, "SELECT id FROM students WHERE reg_number = ?");
        mysqli_stmt_bind_param($check, "s", $reg_number);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $error = "Registration number '{$reg_number}' is already taken. Please use a unique number.";
        } else {
            $stmt = mysqli_prepare($conn,
                "INSERT INTO students (reg_number, first_name, last_name, gender, date_of_birth, school_level, class_grade, region, parent_name, parent_phone)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ssssssssss",
                $reg_number, $first_name, $last_name, $gender, $dob, $level, $grade, $region, $parent_name, $parent_phone
            );

            if (mysqli_stmt_execute($stmt)) {
                $success = "Student '{$first_name} {$last_name}' registered successfully with Reg. No. {$reg_number}!";
            } else {
                $error = "Something went wrong while saving. Please try again.";
            }
        }
    }
}

$regions = ['Dodoma','Dar es Salaam','Arusha','Mwanza','Mbeya','Tanga','Morogoro','Kilimanjaro',
            'Kagera','Iringa','Shinyanga','Tabora','Kigoma','Singida','Rukwa','Lindi','Mtwara',
            'Ruvuma','Pwani','Simiyu','Geita','Katavi','Njombe','Songwe'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student – School SIMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="section-title">📝 Register New Student</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">✅ <?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error">❌ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="form-box">
        <form method="POST" action="register.php">
            <div class="form-grid">

                <div class="form-group">
                    <label>Registration Number *</label>
                    <input type="text" name="reg_number" placeholder="e.g. PS-2025-001" required
                           value="<?php echo isset($_POST['reg_number']) ? htmlspecialchars($_POST['reg_number']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>School Level *</label>
                    <select name="school_level" required>
                        <option value="">-- Select Level --</option>
                        <option value="Primary"   <?php echo (isset($_POST['school_level']) && $_POST['school_level'] === 'Primary')   ? 'selected' : ''; ?>>Primary School</option>
                        <option value="Secondary" <?php echo (isset($_POST['school_level']) && $_POST['school_level'] === 'Secondary') ? 'selected' : ''; ?>>Secondary School</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" placeholder="First name" required
                           value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" placeholder="Last name" required
                           value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Gender *</label>
                    <select name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male"   <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male')   ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date of Birth *</label>
                    <input type="date" name="date_of_birth" required
                           value="<?php echo isset($_POST['date_of_birth']) ? htmlspecialchars($_POST['date_of_birth']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Class / Grade *</label>
                    <input type="text" name="class_grade" placeholder="e.g. Standard 4 or Form 2" required
                           value="<?php echo isset($_POST['class_grade']) ? htmlspecialchars($_POST['class_grade']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Region *</label>
                    <select name="region" required>
                        <option value="">-- Select Region --</option>
                        <?php foreach ($regions as $r): ?>
                            <option value="<?php echo $r; ?>" <?php echo (isset($_POST['region']) && $_POST['region'] === $r) ? 'selected' : ''; ?>>
                                <?php echo $r; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Parent / Guardian Name *</label>
                    <input type="text" name="parent_name" placeholder="Full name of parent/guardian" required
                           value="<?php echo isset($_POST['parent_name']) ? htmlspecialchars($_POST['parent_name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Parent / Guardian Phone *</label>
                    <input type="text" name="parent_phone" placeholder="e.g. 0712345678" required
                           value="<?php echo isset($_POST['parent_phone']) ? htmlspecialchars($_POST['parent_phone']) : ''; ?>">
                </div>

            </div>

            <div style="margin-top:25px; display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary">📥 Register Student</button>
                <a href="students.php" class="btn btn-secondary">📋 View All Students</a>
                <button type="reset" class="btn btn-danger">🔄 Clear Form</button>
            </div>
        </form>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> School SIMS – CP 222 Open Source Technologies | University of Dodoma
</footer>
</body>
</html>

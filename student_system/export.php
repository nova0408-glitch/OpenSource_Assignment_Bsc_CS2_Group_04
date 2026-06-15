<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';

if (isset($_GET['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="students_export.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Reg Number', 'Full Name', 'Gender', 'DOB', 'Level', 'Class', 'Region', 'Parent Name', 'Phone']);

    $result = mysqli_query($conn, "SELECT * FROM students ORDER BY reg_number");
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['reg_number'],
            $row['first_name'] . ' ' . $row['last_name'],
            $row['gender'],
            $row['date_of_birth'],
            $row['school_level'],
            $row['class_grade'],
            $row['region'],
            $row['parent_name'],
            $row['parent_phone']
        ]);
    }
    fclose($output);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export Students</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h2>Export All Students</h2>
        <a href="?export=1" class="btn btn-success">📥 Download CSV File</a>
    </div>
</body>
</html>

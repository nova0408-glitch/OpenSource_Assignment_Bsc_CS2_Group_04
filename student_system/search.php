<?php
require_once 'includes/auth_guard.php';
require_once 'includes/db_connect.php';

$results  = null;
$searched = false;
$keyword  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword  = trim($_POST['keyword']);
    $searched = true;

    if (!empty($keyword)) {
        $safe = mysqli_real_escape_string($conn, $keyword);
        $results = mysqli_query($conn,
            "SELECT * FROM students
             WHERE reg_number LIKE '%$safe%'
                OR first_name LIKE '%$safe%'
                OR last_name  LIKE '%$safe%'
                OR region     LIKE '%$safe%'
                OR class_grade LIKE '%$safe%'
             ORDER BY reg_number ASC"
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students – School SIMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="section-title">🔍 Search Students</h2>

    <div class="form-box">
        <form method="POST" action="search.php">
            <p style="margin-bottom:12px; color:#555;">Search by registration number, name, region, or class/grade.</p>
            <div class="search-box">
                <input type="text" name="keyword" placeholder="e.g. PS-2024-001 or Amina or Dodoma"
                       value="<?php echo htmlspecialchars($keyword); ?>" autofocus required>
                <button type="submit" class="btn btn-primary">🔍 Search</button>
                <a href="search.php" class="btn btn-secondary">🔄 Clear</a>
            </div>
        </form>
    </div>

    <?php if ($searched): ?>
        <?php if ($results && mysqli_num_rows($results) > 0): ?>
            <div class="table-box">
                <p style="margin-bottom:12px; color:#555; font-size:0.9rem;">
                    Found <strong><?php echo mysqli_num_rows($results); ?></strong> result(s) for "<em><?php echo htmlspecialchars($keyword); ?></em>".
                </p>
                <table>
                    <thead>
                        <tr>
                            <th>Reg. Number</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Level</th>
                            <th>Class / Grade</th>
                            <th>Region</th>
                            <th>DOB</th>
                            <th>Parent</th>
                            <th>Phone</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($s = mysqli_fetch_assoc($results)): ?>
                        <tr>
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
                            <td><?php echo date('d M Y', strtotime($s['date_of_birth'])); ?></td>
                            <td><?php echo htmlspecialchars($s['parent_name']); ?></td>
                            <td><?php echo htmlspecialchars($s['parent_phone']); ?></td>
                            <td>
                                <a href="view_student.php?id=<?php echo $s['id']; ?>" class="btn btn-secondary" style="font-size:0.8rem; padding:5px 10px;">👁 View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="form-box">
                <div class="empty-state">
                    <div class="empty-icon">🔎</div>
                    <p>No students found matching "<strong><?php echo htmlspecialchars($keyword); ?></strong>".</p>
                    <p style="margin-top:8px; font-size:0.9rem; color:#aaa;">Try searching by registration number like <em>PS-2024-001</em> or by a name or region.</p>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="form-box" style="text-align:center; padding:40px;">
            <div style="font-size:3rem; margin-bottom:15px;">🔍</div>
            <p style="color:#888;">Enter a registration number, student name, region, or class above to begin searching.</p>
        </div>
    <?php endif; ?>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> School SIMS – CP 222 Open Source Technologies | University of Dodoma
</footer>
</body>
</html>

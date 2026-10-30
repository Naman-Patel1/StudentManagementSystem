
<?php
include 'db.php';

$search = $_GET['search'] ?? '';

if ($search != '') {
    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR course LIKE ? ORDER BY id DESC");
    $value = "%$search%";
    $stmt->bind_param("sss", $value, $value, $value);
    $stmt->execute();
    $students = $stmt->get_result();
} else {
    $students = $conn->query("SELECT * FROM students ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">Student Management System</h2>

    <div class="d-flex justify-content-between mb-3">
        <h4>Student Records</h4>
        <a href="add.php" class="btn btn-primary">Add Student</a>
    </div>

    <form method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Search students..." class="form-control" value="<?php echo htmlspecialchars($search); ?>">
        <button class="btn btn-dark mt-2">Search</button>
        <a href="index.php" class="btn btn-secondary mt-2">Reset</a>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this student?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>


<?php
include 'db.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, course=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $course, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Unable to update student.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Update Student Details</h2>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label>Student Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Course</label>
            <input type="text" name="course" class="form-control" value="<?php echo htmlspecialchars($student['course']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Student</button>

        <a href="index.php" class="btn btn-secondary">Back</a>

    </form>

</div>

</body>
</html>

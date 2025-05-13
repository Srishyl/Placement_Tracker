<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
require_once 'db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="admin-actions">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <h3>Add Student Details</h3>
        <form action="admin_dashboard.php" method="POST">
            <div class="form-group">
                <label for="name">Student Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name" required>
            </div>
            <div class="form-group">
                <label for="usn">USN:</label>
                <input type="text" id="usn" name="usn" required>
            </div>
            <div class="form-group">
                <label for="discipline">Discipline:</label>
                <input type="text" id="discipline" name="discipline" required>
            </div>
            <div class="form-group">
                <label for="package">Package (in LPA):</label>
                <input type="number" step="0.01" id="package" name="package" required>
            </div>
            <button type="submit">Add Student</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Sanitize and validate input
                $name = trim($_POST['name']);
                $company_name = trim($_POST['company_name']);
                $usn = trim($_POST['usn']);
                $discipline = trim($_POST['discipline']);
                $package = floatval($_POST['package']);

                // Validate USN format (assuming format like 1MS20CS001)
                if (!preg_match('/^[1-9][A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{3}$/', $usn)) {
                    throw new Exception("Invalid USN format. Please use format like 1MS20CS001");
                }

                // Check if USN already exists
                $check_stmt = $conn->prepare("SELECT usn FROM students WHERE usn = ?");
                $check_stmt->bind_param("s", $usn);
                $check_stmt->execute();
                $result = $check_stmt->get_result();
                
                if ($result->num_rows > 0) {
                    throw new Exception("Student with this USN already exists");
                }
                $check_stmt->close();

                // Insert new student
                $sql = "INSERT INTO students (name, company_name, usn, discipline, package) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("ssssd", $name, $company_name, $usn, $discipline, $package);
                
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }

                echo "<p class='success'>Student details added successfully!</p>";
                $stmt->close();

            } catch (Exception $e) {
                echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        ?>

        <h3>Student List</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>USN</th>
                    <th>Discipline</th>
                    <th>Package (LPA)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $result = $conn->query("SELECT * FROM students ORDER BY name");
                    if (!$result) {
                        throw new Exception("Query failed: " . $conn->error);
                    }
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['company_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['usn']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['discipline']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['package']) . "</td>";
                        echo "</tr>";
                    }
                } catch (Exception $e) {
                    echo "<tr><td colspan='5' class='error'>Error loading student list: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html> 
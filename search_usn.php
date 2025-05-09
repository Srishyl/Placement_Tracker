<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Search by USN</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="GET">
        <input type="text" name="usn" placeholder="Enter USN">
        <button type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['usn'])) {
        $usn = $_GET['usn'];
        $stmt = $conn->prepare("SELECT * FROM students WHERE usn = ?");
        $stmt->bind_param("s", $usn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<p><strong>{$row['name']}</strong> placed in <strong>{$row['company']}</strong> with package ₹{$row['package']} LPA</p>";
        } else {
            echo "<p>No student found with USN: $usn</p>";
        }
    }
    ?>
</body>
</html>

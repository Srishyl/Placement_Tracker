<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Search by Company</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #7b2cbf;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET">
            <input type="text" name="company" placeholder="Enter Company Name" value="<?php echo isset($_GET['company']) ? htmlspecialchars($_GET['company']) : ''; ?>">
            <button type="submit">Search</button>
        </form>

        <?php
        if (isset($_GET['company'])) {
            $company = $_GET['company'];
            
            // Get the count
            $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM students WHERE company = ?");
            $count_stmt->bind_param("s", $company);
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $count_row = $count_result->fetch_assoc();
            
            // Get the student details
            $stmt = $conn->prepare("SELECT name, usn, discipline, package FROM students WHERE company = ? ORDER BY name");
            $stmt->bind_param("s", $company);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($count_row['total'] > 0) {
                echo "<p><strong>{$count_row['total']}</strong> students placed in <strong>$company</strong></p>";
                
                echo "<table>";
                echo "<tr>
                        <th>Name</th>
                        <th>USN</th>
                        <th>Discipline</th>
                        <th>Package (LPA)</th>
                      </tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['usn']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['discipline']) . "</td>";
                    echo "<td>₹" . htmlspecialchars($row['package']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No placements found for: $company</p>";
            }
        }
        ?>
    </div>
</body>
</html>
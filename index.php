<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Placement Search Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #dee2ff, #edf2fb);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            color: #3a0ca3;
            margin-bottom: 30px;
        }
        .btn {
            display: block;
            margin: 20px auto;
            padding: 15px 30px;
            background-color: #7209b7;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #560bad;
        }
        .admin-links {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .admin-links a {
            display: inline-block;
            margin: 0 10px;
            color: #3a0ca3;
            text-decoration: none;
            font-size: 16px;
        }
        .admin-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Placement Search</h1>
        <a class="btn" href="search_usn.php">🔍 Search by USN</a>
        <a class="btn" href="search_company.php">🏢 Search by Company</a>
        <div class="admin-links">
            <a href="admin_login.php">👤 Admin Login</a>
            <a href="admin_register.php">📝 Admin Registration</a>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Checklist</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="script.js" defer></script>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
    }
    $username = $_SESSION['username'];
    include 'config.php';

    // 사용자 프로필 정보 가져오기
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    ?>
    <div class="container">
        <div class="sidebar">
            <h2>Profile</h2>
            <form id="profile-form">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>
                
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" required>
                
                <label for="body_fat">Body Fat (%):</label>
                <input type="number" id="body_fat" name="body_fat" value="<?php echo htmlspecialchars($user['body_fat']); ?>" required>
                
                <button type="button" onclick="updateProfile()">Update Profile</button>
            </form>
        </div>
        <div class="main-content">
            <h1>Weekly Exercise Checklist</h1>
            <div id="days-container">
                <?php
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                foreach ($days as $day) {
                    echo "
                    <div class='day' id='$day'>
                        <h2>" . ucfirst($day) . "</h2>
                        <div class='input-group'>
                            <input type='text' id='{$day}-input' class='input-routine' placeholder='New Routine Title'>
                            <button onclick='addRoutine(\"$day\")' class='btn-add'><i class='fas fa-plus'></i></button>
                        </div>
                        <div class='routines-list' id='{$day}-routines'></div>
                    </div>";
                }
                ?>
            </div>
            <button id="reset-button">Reset Week</button>
            <form action="logout.php" method="post">
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>

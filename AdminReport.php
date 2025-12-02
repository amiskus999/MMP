<?php
session_start();

// A real application would have a proper admin check.
// For now, we'll just check if the user is logged in.
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 'true') {
    header('Location: Login.php');
    exit();
}

// --- Handle POST Actions (Delist Item or Delete User) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Handle Item Delisting ---
    if (isset($_POST['delist_item_id'])) {
        $itemIdToDelist = $_POST['delist_item_id'];
        $listingsFile = 'data/listings.json';
        if (file_exists($listingsFile)) {
            $listings = json_decode(file_get_contents($listingsFile), true);
            // Filter out the item to be delisted
            $listings = array_filter($listings, function($item) use ($itemIdToDelist) {
                return $item['id'] !== $itemIdToDelist;
            });
            // Re-index array and save
            file_put_contents($listingsFile, json_encode(array_values($listings), JSON_PRETTY_PRINT));
        }
    }

    // --- Handle User Deletion ---
    if (isset($_POST['delete_user_email'])) {
        $emailToDelete = $_POST['delete_user_email'];
        $usersFile = 'data/UserDatabase.txt';
        if (file_exists($usersFile)) {
            $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
            $header = array_shift($lines); // Keep header
            
            $remainingUsers = [];
            foreach ($lines as $line) {
                $userData = explode("\t", $line);
                // Keep the user if the email doesn't match
                if (!isset($userData[1]) || trim($userData[1]) !== $emailToDelete) {
                    $remainingUsers[] = $line;
                }
            }
            
            // Write the header and the remaining users back to the file
            $newContent = $header . "\n" . implode("\n", $remainingUsers);
            file_put_contents($usersFile, $newContent);
        }
    }
}

// --- Get Report Criteria ---
$criteria = $_POST["report_criteria"] ?? 'all';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketplace - Admin Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .report-summary {
            margin-top: 20px;
            font-weight: bold;
            font-style: italic;
        }
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            background-color: #dc3545; /* Red for delete/delist */
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: #c82333;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Reports</h1>
        
        <?php if ($criteria === 'users'): ?>
            <?php
            // --- Logic for User Report ---
            $reportTitle = "All Registered Users";
            $users = [];
            $usersFile = 'data/UserDatabase.txt';
            if (file_exists($usersFile)) {
                $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
                array_shift($lines); // remove header
                foreach ($lines as $line) {
                    $users[] = explode("\t", $line);
                }
            }
            $count = count($users);
            ?>
            <h2><?php echo $reportTitle; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user[0] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user[1] ?? ''); ?></td>
                            <td>
                                <form method="POST" action="AdminReport.php" onsubmit="return confirm('Are you sure you want to delete this user? This is permanent.');">
                                    <input type="hidden" name="report_criteria" value="users">
                                    <input type="hidden" name="delete_user_email" value="<?php echo htmlspecialchars($user[1] ?? ''); ?>">
                                    <button type="submit" class="action-btn">Delete User</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="report-summary">There are <?php echo $count; ?> users in this report.</p>

        <?php else: ?>
            <?php
            // --- Logic for Item Listings Report ---
            $jsonFilePath = 'data/listings.json';
            $listings = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath), true) : [];
            usort($listings, fn($a, $b) => strcasecmp($a['title'], $b['title']));

            $reportTitle = "All Listings";
            if ($criteria !== 'all') {
                $reportTitle = "Listings with Condition: '" . htmlspecialchars($criteria) . "'";
                $listings = array_filter($listings, fn($item) => ($item['condition'] ?? '') === $criteria);
            }
            $count = count($listings);
            ?>
            <h2><?php echo $reportTitle; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Condition</th>
                        <th>Seller Email</th>
                        <th>Posted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listings as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($item['condition']); ?></td>
                            <td><?php echo htmlspecialchars($item['user_email'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($item['posted_at']); ?></td>
                            <td>
                                <form method="POST" action="AdminReport.php" onsubmit="return confirm('Are you sure you want to delist this item?');">
                                    <input type="hidden" name="report_criteria" value="<?php echo htmlspecialchars($criteria); ?>">
                                    <input type="hidden" name="delist_item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <button type="submit" class="action-btn">Delist</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="report-summary">There are <?php echo $count; ?> entries in this report, sorted by title.</p>
        <?php endif; ?>

        <a href="RequestReport.php" class="back-link">&laquo; Back to Report Request</a>
    </div>
</body>
</html>

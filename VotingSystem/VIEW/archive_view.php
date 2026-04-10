<?php include("../MODEL/fetch_archive.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Archive - MULAT</title>
    <link rel="stylesheet" href="../CSS/archive_view.css">
</head>
<body>

    <div class="header-top">
        <a href="../CONTROLLER(BACKEND)/logout.php" class="logout">LOG OUT</a>
    </div>

    <nav class="header-nav">
        <a href="HTML/dasboardOFFICER.html" class="active">CANDIDATE MANAGEMENT</a>
        <a href="HTML/dasboardAUDITOR.html">VOTE UPDATE</a>
        <a href="result_history.php">VOTING HISTORY</a>
        <a href="HTML/dasboardADMIN.html">DASHBOARD</a>
        <a href="HTML/voterlist.html">INFORMATION MANAGEMENT</a>
        <a href="HTML/registration.html">REGISTRATION</a>
    </nav>

    <div class="page-title">
        <h2>CANDIDATE ARCHIVE</h2>
        <p>Archived candidates can be restored or permanently deleted</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Course / College</th>
                    <th>Position</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="archiveTableBody">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php
                            // Parse stored label "name | course | college"
                            $parts = explode(' | ', $row['candidate_name']);
                            $displayName = trim($parts[0]);
                            $displayCourse = isset($parts[1]) ? trim($parts[1]) . ' / ' . trim($parts[2] ?? '') : '—';
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($displayName); ?></td>
                            <td><?php echo htmlspecialchars($displayCourse); ?></td>
                            <td><?php echo htmlspecialchars($row['position_name']); ?></td>
                            <td style="text-align:center;">
                                <button class="btn-restore" data-id="<?php echo $row['archive_id']; ?>">RESTORE</button>
                                <button class="btn-perm-delete" data-id="<?php echo $row['archive_id']; ?>">DELETE FOREVER</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="4">No archived candidates found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="../JS/jquery-4.0.0.min.js"></script>
    <script src="../JS/CONTROLLER(FRONTEND)/archive.js"></script>
</body>
</html>
<?php
ob_start();
include("../MODEL/connect.php");

$action = $_POST['action'] ?? '';

// --- CREATE ELECTION ---
if ($action === 'create_election') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $start       = $_POST['start'] ?? '';
    $end         = $_POST['end'] ?? '';

    if (empty($title) || empty($start) || empty($end)) {
        echo "Error: Missing required fields (Title, Start, or End date)."; exit;
    }

    // Convert datetime-local 'T' to space for MySQL
    $start = str_replace('T', ' ', $start);
    $end   = str_replace('T', ' ', $end);

    $stmt = $conn->prepare("INSERT INTO elections (title, description, start, end, status) VALUES (?, ?, ?, ?, 'Draft')");
    $stmt->bind_param("ssss", $title, $description, $start, $end);
    if ($stmt->execute()) {
        echo "success:" . $conn->insert_id;
    } else {
        echo "Error: " . $conn->error;
    }
    exit;
}

// --- ADD POSITION ---
if ($action === 'add_position') {
    $election_id = intval($_POST['election_id'] ?? 0);
    $name        = $_POST['position_name'] ?? '';
    $max_votes   = intval($_POST['max_votes'] ?? 1);
    $priority    = intval($_POST['priority_order'] ?? 1);

    if (!$election_id || !$name) {
        echo "missing_data"; exit;
    }

    $stmt = $conn->prepare("INSERT INTO positions (election_id, position_name, max_votes_allowed, priority_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $election_id, $name, $max_votes, $priority);
    echo $stmt->execute() ? "success" : "error: " . $conn->error;
    exit;
}

// --- GET ALL ELECTIONS ---
if ($action === 'get_elections') {
    ob_clean();
    header('Content-Type: application/json');
    $result = $conn->query("SELECT * FROM elections ORDER BY election_id DESC");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    exit;
}

// --- GET ALL POSITIONS (for candidate management dropdown) ---
if ($action === 'get_all_positions') {
    $result = $conn->query("SELECT p.position_id, p.position_name, p.priority_order, e.title as election_title 
                            FROM positions p 
                            JOIN elections e ON p.election_id = e.election_id 
                            ORDER BY p.priority_order ASC");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    echo json_encode($rows);
    exit;
}

// --- GET POSITIONS FOR A SPECIFIC ELECTION ---
if ($action === 'get_positions') {
    header('Content-Type: application/json');
    $election_id = intval($_POST['election_id'] ?? 0);
    $stmt = $conn->prepare("SELECT * FROM positions WHERE election_id = ? ORDER BY priority_order ASC");
    $stmt->bind_param("i", $election_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    echo json_encode($rows);
    exit;
}

// --- DELETE POSITION ---
if ($action === 'delete_position') {
    $position_id = intval($_POST['position_id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM positions WHERE position_id = ?");
    $stmt->bind_param("i", $position_id);
    echo $stmt->execute() ? "success" : "error: " . $conn->error;
    exit;
}

echo "invalid_action";
ob_end_flush();

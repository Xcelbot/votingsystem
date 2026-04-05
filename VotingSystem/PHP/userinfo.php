<?php
include("connect.php");

// 1. Get the ID sent from AJAX
$id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

// 2. Query matches your 'user_id' column
$sql = "SELECT * FROM users WHERE user_id = '$id'";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo "
    <h2 style='border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 20px;'>USER INFORMATION UPDATE</h2>
    <form id='updateForm'>
        <input type='hidden' name='user_id' value='{$row['user_id']}'>
        
        <div style='margin-bottom: 15px;'>
            <label>Full Name</label><br>
            <input type='text' name='fullname' value='{$row['fullname']}' style='width: 95%; padding: 8px;'>
        </div>

        <div style='margin-bottom: 15px;'>
            <input type='text' name='school_id' value='{$row['school_id']}' placeholder='School ID' style='width: 45%; padding: 8px;'>
            <input type='email' name='email' value='{$row['email']}' placeholder='Email Address' style='width: 45%; padding: 8px;'>
        </div>

        <div style='margin-bottom: 15px;'>
            <select name='college' style='width: 31%; padding: 8px;'>
                <option value='CICT' ".($row['college'] == 'CICT' ? 'selected' : '').">CICT</option>
            </select>
            <select name='course' style='width: 31%; padding: 8px;'>
                <option value='BSIT' ".($row['course'] == 'BSIT' ? 'selected' : '').">BSIT</option>
                <option value='BSIS' ".($row['course'] == 'BSIS' ? 'selected' : '').">BSIS</option>
                <option value='BLIS' ".($row['course'] == 'BLIS' ? 'selected' : '').">BLIS</option>
            </select>
            <select name='year_level' style='width: 31%; padding: 8px;'>
                <option value='1' ".($row['year_level'] == '1' ? 'selected' : '').">1st Year</option>
                <option value='2' ".($row['year_level'] == '2' ? 'selected' : '').">2nd Year</option>
                <option value='3' ".($row['year_level'] == '3' ? 'selected' : '').">3rd Year</option>
                <option value='4' ".($row['year_level'] == '4' ? 'selected' : '').">4th Year</option>
            </select>
        </div>

        <div style='margin-bottom: 20px;'>
            <label>Role:</label>
            <select name='role_id' style='padding: 8px;'>
                <option value='1' ".($row['role_id'] == '1' ? 'selected' : '').">Admin</option>
                <option value='2' ".($row['role_id'] == '2' ? 'selected' : '').">Officer</option>
                <option value='3' ".($row['role_id'] == '3' ? 'selected' : '').">Auditor</option>
                <option value='4' ".($row['role_id'] == '4' ? 'selected' : '').">Voter</option>
            </select>
        </div>

        <button type='button' id='backBtn' style='padding: 10px 20px; cursor: pointer;'>BACK</button>
        <button type='submit' style='padding: 10px 20px; background: #ddd; border: 1px solid #999; cursor: pointer;'>SAVE CHANGES</button>
    </form>";
} else {
    echo "No user found with ID: " . htmlspecialchars($id);
}
?>

<style>
    .form-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85em; color: #666; margin-bottom: 5px; font-weight: bold; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    .footer-btns { margin-top: 25px; display: flex; gap: 10px; }
    .save-btn { background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; }
    .back-btn { background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
</style>

<?php if (!$user): ?>
    <div style="text-align:center; padding: 30px;">
        <p>User record not found.</p>
        <button class="back-btn" id="backBtn">Go Back</button>
    </div>
<?php else: ?>
    <div class="form-header">
        <h3 style="margin:0;">Editing: <?php echo htmlspecialchars($user['fullname']); ?></h3>
        <span style="font-size: 0.8em; color: #999;">User ID: <?php echo $user['user_id']; ?></span>
    </div>

    <form id="updateForm">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>School ID Number</label>
                <input type="text" name="school_id" value="<?php echo htmlspecialchars($user['school_id']); ?>" required>
            </div>
            <div class="form-group">
                <label>Full Name (Last, First)</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label>Course</label>
            <select name="course">
                <option value="Bachelor of Science in Information Technology" <?php echo ($user['course'] == 'Bachelor of Science in Information Technology') ? 'selected' : ''; ?>>BSIT</option>
                <option value="Bachelor of Science in Information Systems" <?php echo ($user['course'] == 'Bachelor of Science in Information Systems') ? 'selected' : ''; ?>>BSIS</option>
                <option value="Bachelor of Library and Information Science" <?php echo ($user['course'] == 'Bachelor of Library and Information Science') ? 'selected' : ''; ?>>BLIS</option>
            </select>
        </div>

        <div class="footer-btns">
            <button type="submit" class="save-btn">SAVE CHANGES</button>
            <button type="button" class="back-btn" id="backBtn">CANCEL</button>
        </div>
    </form>
<?php endif; ?>
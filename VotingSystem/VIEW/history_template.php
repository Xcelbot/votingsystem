<style>
    .status-badge {
        background: #27ae60;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75em;
        text-transform: uppercase;
    }
    .time-text { color: #27ae60; font-weight: bold; }
    .date-text { color: #888; font-size: 0.85em; }
</style>

<?php if (empty($history)): ?>
    <tr>
        <td colspan="4" style="text-align:center; padding: 20px; color: #999;">
            No recent voting activity detected.
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($history as $voter): ?>
        <tr>
            <td><?php echo htmlspecialchars($voter['school_id']); ?></td>
            <td>
                <strong><?php echo htmlspecialchars($voter['fullname']); ?></strong><br>
                <small style="color: #777;"><?php echo htmlspecialchars($voter['email']); ?></small>
            </td>
            <td>
                <span class="time-text"><?php echo $voter['v_time']; ?></span><br>
                <span class="date-text"><?php echo $voter['v_date']; ?></span>
            </td>
            <td>
                <span class="status-badge"><?php echo $voter['status']; ?></span>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
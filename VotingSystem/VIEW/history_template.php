<?php if (empty($history)): ?>
    <tr class="empty-row">
        <td colspan="5">No recent voting activity detected.</td>
    </tr>
<?php else: ?>
    <?php foreach ($history as $voter): ?>
        <tr>
            <td><?php echo htmlspecialchars($voter['school_id']); ?></td>
            <td><strong><?php echo htmlspecialchars($voter['fullname']); ?></strong></td>
            <td><?php echo htmlspecialchars($voter['email']); ?></td>
            <td style="color: #4CAF50; font-weight: bold;"><?php echo $voter['v_time']; ?></td>
            <td style="color: #aaa;"><?php echo $voter['v_date']; ?></td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
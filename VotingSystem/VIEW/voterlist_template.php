<style>
    .voter-table { width: 100%; border-collapse: collapse; background: white; }
    .voter-table th { background: #f4f4f4; padding: 12px; text-align: left; font-size: 0.85em; color: #666; border-bottom: 2px solid #ddd; }
    .voter-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 0.9em; }
    .status-badge { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 0.75em; font-weight: bold; text-transform: uppercase; }
    .timestamp { color: #888; font-size: 0.85em; }
</style>

<?php if (empty($voters)): ?>
    <div style="text-align:center; padding: 40px; color: #999; background: white; border: 1px solid #ddd;">
        No votes have been cast yet.
    </div>
<?php else: ?>
    <table class="voter-table">
        <thead>
            <tr>
                <th>School ID</th>
                <th>Voter Name</th>
                <th>Course</th>
                <th>Status</th>
                <th>Date/Time Submited</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($voters as $v): ?>
                <tr>
                    <td><?php echo htmlspecialchars($v['school_id']); ?></td>
                    <td><strong><?php echo htmlspecialchars($v['fullname']); ?></strong></td>
                    <td><?php echo htmlspecialchars($v['course']); ?></td>
                    <td><span class="status-badge">Voted</span></td>
                    <td class="timestamp">
                        <?php echo date("M d, Y | h:i A", strtotime($v['voted_at'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
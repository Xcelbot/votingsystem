<style>
    .course-section { margin-bottom: 30px; border: 1px solid #ddd; }
    .course-title { background: #333; color: #fff; padding: 10px; font-weight: bold; }
    .pos-group-title { background: #f8f9fa; padding: 8px 15px; font-weight: bold; color: #800000; border-bottom: 1px solid #eee; }
    .manage-table { width: 100%; border-collapse: collapse; }
    .manage-table td { padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 0.9em; }
    .action-btns { text-align: right; }
    .btn-edit { background: #ffc107; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
    .btn-delete { background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-left: 5px; }
</style>

<?php if (empty($groupedCandidates)): ?>
    <div style="text-align:center; padding: 40px; color: #999;">No candidates registered.</div>
<?php else: ?>
    <?php foreach ($groupedCandidates as $course => $positions): ?>
        <div class="course-section">
            <div class="course-title"><?php echo htmlspecialchars($course); ?></div>
            
            <?php foreach ($positions as $posName => $candidates): ?>
                <div class="pos-group-title"><?php echo $posName; ?></div>
                <table class="manage-table">
                    <?php foreach ($candidates as $can): ?>
                        <tr>
                            <td style="width: 40%;"><?php echo htmlspecialchars($can['candidate_name']); ?></td>
                            <td style="width: 40%; color: #666; font-size: 0.8rem;"><?php echo htmlspecialchars($can['college']); ?></td>
                            <td class="action-btns">
                                <button class="btn-edit edit-candidate" 
                                        data-id="<?php echo $can['candidate_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($can['candidate_name']); ?>"
                                        data-course="<?php echo $can['course']; ?>"
                                        data-pos="<?php echo $can['position_id']; ?>">
                                    Edit
                                </button>
                                <button class="btn-delete del-candidate" data-id="<?php echo $can['candidate_id']; ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
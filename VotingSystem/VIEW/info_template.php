<?php if (empty($usersByRole)): ?>
    <div style="text-align:center; padding: 40px; color: #999;">
        No records found matching your search.
    </div>
<?php else: ?>
    <?php foreach ($roleSettings as $id => $role): ?>
        
        <?php if (isset($usersByRole[$id])): ?>
            <div class="role-section" style="margin-bottom: 30px;">
                <div style="background: <?php echo $role['color']; ?>; color: white; padding: 10px; font-weight: bold; width: fit-content; min-width: 150px; margin-bottom: 5px; font-size: 0.9em; text-transform: uppercase;">
                    <?php echo $role['name']; ?>
                </div>

                <table style="width: 100%; border-collapse: collapse; background: white; border: 1px solid #ddd;">
                    <thead>
                        <tr style="background: #f8f9fa; text-align: left; font-size: 0.85em; color: #666; border-bottom: 1px solid #ddd;">
                            <th style="padding: 10px;">User ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <?php if ($role['showCourse']): ?>
                                <th>Course</th>
                            <?php endif; ?>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usersByRole[$id] as $user): ?>
                            <tr style="border-bottom: 1px solid #eee; font-size: 0.9em;">
                                <td style="padding: 10px;"><?php echo htmlspecialchars($user['school_id']); ?></td>
                                <td><strong><?php echo htmlspecialchars($user['fullname']); ?></strong></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <?php if ($role['showCourse']): ?>
                                    <td><?php echo htmlspecialchars($user['course']); ?></td>
                                <?php endif; ?>
                                <td style="text-align: center; padding: 8px;">
                                    <button class="view-btn" data-id="<?php echo $user['user_id']; ?>">View</button>
                                    <button class="del-btn" data-id="<?php echo $user['user_id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
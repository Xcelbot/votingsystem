<?php foreach ($groupedCandidates as $courseCode => $positionsList): ?>
    <tr style="background-color: #343a40; color: white; font-weight: bold;">
        <td colspan="4" style="text-align: center;">
            <?php echo $course_titles[$courseCode] ?? $courseCode; ?>
        </td>
    </tr>

    <?php foreach ($positionsList as $posId => $candidatesList): ?>
        <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <td colspan="4" style="padding-left: 15px; font-weight: bold; color: #495057;">
                Position: <?php echo $positions[$posId] ?? "CANDIDATE"; ?>
            </td>
        </tr>

        <?php foreach ($candidatesList as $row): ?>
            <tr>
                <td style="padding-left: 40px;"><?php echo $row['candidate_name']; ?></td>
                <td style="text-align: center; color: #6c757d;"><?php echo $row['course']; ?></td>
                <td><?php echo $row['college']; ?></td>
                <td style="text-align: center;">
                    <button class="edit-btn" 
                        data-id="<?php echo $row['candidate_id']; ?>" 
                        data-name="<?php echo $row['candidate_name']; ?>" 
                        data-course="<?php echo $row['course']; ?>" 
                        data-college="<?php echo $row['college']; ?>" 
                        data-pos="<?php echo $row['position_id']; ?>">
                        Edit
                    </button>
                    <button class="delete-btn" data-id="<?php echo $row['candidate_id']; ?>">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
<style>
    .pos-card { background: #444; margin-bottom: 25px; padding: 15px; border-radius: 5px; color: white; }
    .pos-header { background: #555; text-align: center; padding: 10px; font-weight: bold; margin-bottom: 10px; }
    .res-table { width: 100%; border-collapse: collapse; background: white; color: #333; }
    .res-table th, .res-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    .vote-count { text-align: center; color: #27ae60; font-weight: bold; }
    .abstain-row { background: #f1f1f1; font-style: italic; color: #666; }
</style>

<?php foreach ($resultsByPosition as $posId => $candidates): ?>
    <div class="pos-card">
        <div class="pos-header">
            <?php echo $positionNames[$posId] ?? "POSITION $posId"; ?>
        </div>

        <table class="res-table">
            <thead>
                <tr>
                    <th width="40%">NAME</th>
                    <th width="40%">COLLEGE</th>
                    <th width="20%" style="text-align:center;">VOTES</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $votesCastInThisPosition = 0; 
                foreach ($candidates as $can): 
                    $votesCastInThisPosition += $can['total_votes'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($can['candidate_name']); ?></td>
                        <td><?php echo htmlspecialchars($can['college']); ?></td>
                        <td class="vote-count"><?php echo $can['total_votes']; ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php $abstainCount = max(0, $totalVoters - $votesCastInThisPosition); ?>
                <tr class="abstain-row">
                    <td colspan="2">ABSTAIN (No selection / None)</td>
                    <td class="vote-count" style="color:#666;"><?php echo $abstainCount; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<?php if (empty($resultsByPosition)): ?>
    <div style="text-align:center; color:white; padding:20px;">Waiting for election data...</div>
<?php endif; ?>
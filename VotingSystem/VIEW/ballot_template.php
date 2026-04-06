<?php if (empty($ballotData)): ?>
    <div style="text-align: center; padding: 50px; background: #ffffff; border: 1px solid #dee2e6; margin-top: 20px;">
        <h3 style="color: #000000;">No candidates found for your course</h3>
        <p style="color: #444444;">Searching for: <strong><?php echo htmlspecialchars($courseCode); ?></strong></p>
    </div>
<?php else: ?>
    <form action="../CONTROLLER(BACKEND)/save_votes.php" method="POST" id="votingForm" style="max-width: 800px; margin: auto;">
        <?php foreach ($ballotData as $posId => $candidates): ?>
            <div class="position-group" style="margin-bottom: 30px; background: #ffffff; padding: 25px; border: 1px solid #e0e0e0; border-radius: 8px;">
                
                <h3 style="color: #000000 !important; border-bottom: 2px solid #2ecc71; padding-bottom: 8px; text-transform: uppercase; font-family: sans-serif; font-size: 1.2rem;">
                    <?php echo $positions[$posId] ?? "Position ID: $posId"; ?>
                </h3>

                <?php foreach ($candidates as $c): ?>
                    <div class="candidate-option" style="margin: 15px 0;">
                        <label style="color: #000000; cursor: pointer; display: flex; align-items: center; width: 100%;">
                            <input type="radio" 
                                   name="votes[<?php echo $posId; ?>]" 
                                   value="<?php echo $c['candidate_id']; ?>" 
                                   required 
                                   style="transform: scale(1.3); margin-right: 15px;">
                            
                            <div>
                                <span style="font-weight: bold; font-size: 1.1rem; color: #000000 !important; display: block;">
                                    <?php echo htmlspecialchars($c['candidate_name']); ?>
                                </span>
                                <span style="display: block; font-size: 0.9rem; color: #000000;">
                                    <?php echo htmlspecialchars($c['college']); ?>
                                </span>
                            </div>
                        </label>
                    </div>
                <?php endforeach; ?>

                <div style="margin-top: 15px; border-top: 1px dashed #000000; padding-top: 10px;">
                    <label style="color: #000000; cursor: pointer; font-style: italic; display: flex; align-items: center;">
                        <input type="radio" name="votes[<?php echo $posId; ?>]" value="abstain" style="margin-right: 10px;">
                        <span>Abstain (No Vote)</span>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="text-align: center; margin-top: 30px; margin-bottom: 50px;">

        </div>
    </form>
<?php endif; ?>
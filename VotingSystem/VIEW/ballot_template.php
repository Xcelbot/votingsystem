<?php if (empty($ballotData)): ?>
    <div style="text-align: center; padding: 50px;">
        <h3>No candidates found for your course</h3>
        <p>Searching for: <strong><?php echo htmlspecialchars($courseCode); ?></strong></p>
    </div>
<?php else: ?>
    <style>
        .custom-radio { opacity: 0; position: absolute; z-index: -1; }
        .radio-circle { width: 14px; height: 14px; border-radius: 50%; background: #dedede; margin-right: 15px; flex-shrink: 0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.3); }
        .custom-radio:checked + .radio-circle { background: #dedede; border: 4px solid #362e2e; }
        .abstain-label { cursor: pointer; display: block; width: 100%; text-align: center; color: #111; font-family: 'Cinzel', serif; font-size: 13px; font-weight: bold; letter-spacing: 2px; }
        .abstain-radio { opacity: 0; position: absolute; z-index: -1; }
        .abstain-radio:checked + .abstain-text { color: #fff; text-shadow: 0 0 5px #000; }
    </style>

    <form action="../CONTROLLER(BACKEND)/svotes.php" method="POST" id="votingForm">
        <?php foreach ($ballotData as $posName => $posInfo): 
            $posId = $posInfo['id'];
            $candidates = $posInfo['candidates'];
        ?>
            <div class="position-group" style="margin-bottom: 20px; border: 3px solid #7a7071;">
                <h3 style="margin: 0; background: #362e2e; color: #fff; padding: 6px; text-align: center; font-family: 'Cinzel', serif; font-size: 16px; letter-spacing: 2px; text-transform: uppercase;">
                    <?php echo htmlspecialchars($posName); ?>
                </h3>

                <div style="background: #a39595; padding: 15px 30px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <?php foreach ($candidates as $c): ?>
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" class="custom-radio" name="votes[<?php echo $posId; ?>]" value="<?php echo $c['candidate_id']; ?>" required>
                                <div class="radio-circle"></div>
                                <div style="font-family: 'Cinzel', serif; line-height: 1.2;">
                                    <div style="font-weight: bold; font-size: 12px; color: #111;"><?php echo htmlspecialchars($c['candidate_name']); ?></div>
                                    <div style="font-size: 8px; color: #333; margin-top: 2px;"><?php echo htmlspecialchars($c['college']); ?></div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div style="background: #7a7071; padding: 4px; border-top: 1px solid #6b6163;">
                    <label class="abstain-label">
                        <input type="radio" class="abstain-radio" name="votes[<?php echo $posId; ?>]" value="abstain">
                        <span class="abstain-text">ABSTAIN</span>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="text-align: center; margin-top: 30px; margin-bottom: 20px;">
            <button type="submit" id="submitVoteBtn" style="background: #362e2e; color: #fff; padding: 10px 60px; border: none; font-family: 'Cinzel', serif; font-size: 15px; letter-spacing: 3px; font-weight: bold; cursor: pointer;">
                SUBMIT
            </button>
            <p style="font-size: 8px; color: #444; margin-top: 15px; font-family: 'Montserrat', sans-serif;">
                Click submit to cast your votes. After this, you will be directed to the logout page.
            </p>
        </div>
    </form>
<?php endif; ?>
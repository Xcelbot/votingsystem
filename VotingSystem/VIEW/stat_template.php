<div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; font-family: sans-serif;">
    <h2 style="color: #333; margin-top: 0;">Election Participation</h2>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="font-size: 2rem; font-weight: bold; margin: 0; color: #4CAF50;"><?php echo $percent; ?>%</p>
            <p style="color: #666; margin: 0;"><?php echo $current; ?> out of <?php echo $total; ?> Students Voted</p>
        </div>
        <div style="width: 150px; background: #eee; height: 15px; border-radius: 10px; overflow: hidden;">
            <div style="width: <?php echo $percent; ?>%; background: #4CAF50; height: 100%;"></div>
        </div>
    </div>
</div>

<div class="history-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); font-family: sans-serif;">
    <h2 style="color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px;">Live Result History</h2>

    <?php 
    $currentPos = null;
    foreach ($liveResults as $row): 
        if ($currentPos !== $row['position_id']): 
            $currentPos = $row['position_id'];
    ?>
        <h4 style="background: #f4f4f4; padding: 5px 10px; margin-top: 20px; color: #555;">
            <?php echo $positions[$currentPos] ?? "POSITION " . $currentPos; ?>
        </h4>
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #eee;">
        <span style="font-weight: bold; color: #333;">
            <?php echo htmlspecialchars($row['candidate_name']); ?>
            <small style="display: block; color: #888; font-weight: normal;"><?php echo $row['course']; ?></small>
        </span>
        
        <div style="text-align: right;">
            <span style="font-size: 1.1rem; font-weight: bold; color: #4CAF50;">
                <?php echo $row['vote_count']; ?>
            </span>
            <span style="color: #999; font-size: 0.8rem;"> votes</span>
        </div>
    </div>

    <?php endforeach; ?>
</div>
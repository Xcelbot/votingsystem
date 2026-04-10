<div style="display: flex; justify-content: space-around; width: 100%; align-items: center;">
    <div class="stat-item">
        <label style="display:block; font-size:9px; color:#888; letter-spacing:1px;">TOTAL ENROLLED</label>
        <span style="font-size:18px; font-weight:bold; color:#fff;"><?php echo $total; ?></span>
    </div>
    
    <div class="stat-item" style="text-align: center;">
        <label style="display:block; font-size:9px; color:#888; letter-spacing:1px;">VOTES CAST</label>
        <span style="font-size:18px; font-weight:bold; color:#fff;"><?php echo $current; ?></span>
    </div>

    <div class="stat-item" style="text-align: right; min-width: 150px;">
        <label style="display:block; font-size:9px; color:#888; letter-spacing:1px;">TURNOUT PROGRESS (<?php echo $percent; ?>%)</label>
        <div style="width: 100%; background: rgba(255,255,255,0.1); height: 6px; border-radius: 10px; margin-top: 5px; overflow: hidden;">
            <div style="width: <?php echo $percent; ?>%; background: #fff; height: 100%; box-shadow: 0 0 10px rgba(255,255,255,0.5);"></div>
        </div>
    </div>
</div>
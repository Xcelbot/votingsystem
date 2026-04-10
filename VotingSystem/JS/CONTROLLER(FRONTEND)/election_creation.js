$(document).ready(function () {

    var currentElectionId = null;

    // ── Load elections on startup ──
    loadElections();

    function loadElections() {
        // Cache buster to ensure fresh data
        const apiUrl = '../../CONTROLLER(BACKEND)/election_mgmt.php?cache=' + new Date().getTime();
        
        $.ajax({
            url: apiUrl,
            type: 'POST',
            data: { action: 'get_elections' },
            success: function(res) {
                try {
                    // Smart Parsing: Only parse if 'res' is still a string
                    var elections = (typeof res === 'string') ? JSON.parse(res.trim()) : res;
                    
                    renderElectionCards(elections);
                    populateElectionDropdown(elections);
                } catch (e) {
                    console.error("Data Parse Failure. Server sent:", res);
                    const snippet = (typeof res === 'string') ? res.substring(0, 50) + "..." : "Object Data";
                    $('#electionsList').html('<div class="empty-msg"><p style="color:#ff6b6b; margin-bottom:10px;">Data Sync Error</p><pre style="font-size:10px; color:#888; background:rgba(0,0,0,0.2); padding:5px; margin-bottom:10px; max-width:100%; overflow:hidden;">' + snippet + '</pre><button class="btn-sm" onclick="location.reload()">REFRESH PAGE</button></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Network Error:", status, error);
                $('#electionsList').html('<div class="empty-msg"><p style="color:#ff6b6b; margin-bottom:10px;">Connection Interrupted</p><button class="btn-sm" onclick="location.reload()">TRY AGAIN</button></div>');
            },
            complete: function() {
                // Failsafe: If one minute passes and it's still "Loading...", something is wrong
                setTimeout(function() {
                    if ($('#electionsList').text().includes('Loading...')) {
                        $('#electionsList').html('<p class="empty-msg">No elections found (Timeout).</p>');
                    }
                }, 5000);
            }
        });
    }

    function renderElectionCards(elections) {
        var html = '';
        if (elections.length === 0) {
            html = '<p class="empty-msg">No elections created yet.</p>';
        } else {
            elections.forEach(function (e) {
                var statusClass = 'status-' + e.status.toLowerCase();
                html += '<div class="election-card">' +
                    '<div class="e-title">' + e.title + '<span class="e-status ' + statusClass + '">' + e.status + '</span></div>' +
                    '<div class="e-meta">Start: ' + (e.start || '—') + ' &nbsp;|&nbsp; End: ' + (e.end || '—') + '</div>' +
                    (e.description ? '<div class="e-meta" style="margin-top:4px;">' + e.description + '</div>' : '') +
                    '</div>';
            });
        }
        $('#electionsList').html(html);
    }

    function populateElectionDropdown(elections) {
        var opts = '<option value="">-- Select an Election --</option>';
        elections.forEach(function (e) {
            // Only add options that have a title and ID
            if (e.election_id && e.title && e.title.trim() !== "") {
                opts += '<option value="' + e.election_id + '">' + e.title + '</option>';
            }
        });
        $('#electionSelect').html(opts);
    }

    // ── Create Election Form ──
    $('#electionForm').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serialize() + '&action=create_election';
        $.post('../../CONTROLLER(BACKEND)/election_mgmt.php', data, function (res) {
            var r = res.trim();
            if (r.startsWith('success:')) {
                var newId = r.split(':')[1];
                alert('Election created successfully!');
                $('#electionForm')[0].reset();
                loadElections();
            } else {
                alert('Error: ' + r);
            }
        });
    });

    // ── Load positions when election is selected ──
    $('#electionSelect').on('change', function () {
        currentElectionId = $(this).val();
        if (!currentElectionId) {
            $('#positionTableBody').html('<tr><td colspan="4" class="empty-msg">Select an election above.</td></tr>');
            return;
        }
        loadPositions(currentElectionId);
    });

    function loadPositions(electionId) {
        $.post('../../CONTROLLER(BACKEND)/election_mgmt.php', { action: 'get_positions', election_id: electionId }, function (res) {
            try {
                // Smart Parsing
                var positions = (typeof res === 'string') ? JSON.parse(res.trim()) : res;
                var html = '';
                if (positions.length === 0) {
                    html = '<tr><td colspan="4" class="empty-msg">No positions yet. Add one below.</td></tr>';
                } else {
                    positions.forEach(function (p) {
                        html += '<tr>' +
                            '<td>' + p.position_name + '</td>' +
                            '<td style="text-align:center;">' + p.max_votes_allowed + '</td>' +
                            '<td style="text-align:center;">' + p.priority_order + '</td>' +
                            '<td style="text-align:center;"><button class="btn-sm del-position" data-id="' + p.position_id + '">Delete</button></td>' +
                            '</tr>';
                    });
                }
                $('#positionTableBody').html(html);
            } catch (e) { 
                console.error("Positions parse error:", res); 
                $('#positionTableBody').html('<tr><td colspan="4" class="empty-msg" style="color:#ff6b6b;">Failed to load positions.</td></tr>');
            }
        });
    }

    // ── Add Position ──
    $('#positionForm').on('submit', function (e) {
        e.preventDefault();
        if (!currentElectionId) { alert('Please select an election first.'); return; }
        var data = $(this).serialize() + '&action=add_position&election_id=' + currentElectionId;
        $.post('../../CONTROLLER(BACKEND)/election_mgmt.php', data, function (res) {
            if (res.trim() === 'success') {
                $('#positionForm')[0].reset();
                loadPositions(currentElectionId);
            } else {
                alert('Error: ' + res);
            }
        });
    });

    // ── Delete Position ──
    $(document).on('click', '.del-position', function () {
        var pid = $(this).data('id');
        if (confirm('Delete this position?')) {
            $.post('../../CONTROLLER(BACKEND)/election_mgmt.php', { action: 'delete_position', position_id: pid }, function (res) {
                if (res.trim() === 'success') {
                    loadPositions(currentElectionId);
                } else { alert('Error: ' + res); }
            });
        }
    });

});

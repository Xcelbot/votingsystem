$(document).ready(function () {

    // ── Step 1: Check if positions exist. If not, show lock screen ──
    $.post('../../CONTROLLER(BACKEND)/election_mgmt.php', { action: 'get_all_positions' }, function (res) {
        try {
            var positions = JSON.parse(res);
            if (positions.length === 0) {
                // No positions — show lock screen
                $('#lockScreen').show();
            } else {
                // Positions exist — show main content
                $('#mainContent').show();

                // Populate the position dropdown
                var opts = '<option value="">Select Position</option>';
                positions.forEach(function (p) {
                    opts += '<option value="' + p.position_id + '">' + p.position_name + '</option>';
                });
                $('#pos_input').html(opts);

                // Load candidate table
                loadTable();
            }
        } catch (e) {
            console.error("Position check error:", res);
            $('#lockScreen').show();
        }
    });

    // ── Load candidate table ──
    function loadTable() {
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/cretrieve.php',
            type: 'GET',
            success: function (data) {
                $('#presidentData').html(data);
            }
        });
    }

    // ── Delete / Archive ──
    $(document).on('click', '.delete-btn', function () {
        var c_id = $(this).data('id');
        if (confirm("Move this candidate to the archive?")) {
            $.ajax({
                url: '../../CONTROLLER(BACKEND)/cdelete.php',
                type: 'POST',
                data: { candidate_id: c_id, action: 'archive' },
                success: function (response) {
                    if (response.trim() == "success") {
                        alert("Candidate moved to archive!");
                        loadTable();
                    } else {
                        alert(response);
                    }
                },
                error: function () { alert("Connection error. Please try again."); }
            });
        }
    });

    // ── Edit: fill form ──
    $(document).on('click', '.edit-btn', function () {
        $('#c_id').val($(this).data('id'));
        $('#name_input').val($(this).data('name'));
        $('#course_select').val($(this).data('course'));
        $('#college_select').val($(this).data('college'));
        $('#pos_input').val($(this).data('pos'));
        $('#action_val').val('update');
        $('#btn').text('UPDATE');
        $('#cancelBtn').show();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ── Reset form ──
    function resetForm() {
        $('#candidateForm')[0].reset();
        $('#c_id').val('');
        $('#action_val').val('add');
        $('#btn').text('ADD');
        $('#cancelBtn').hide();
    }

    // ── Submit form ──
    $('#candidateForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/candidate.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.trim() == "success") {
                    alert("Operation Successful!");
                    resetForm();
                    loadTable();
                } else {
                    alert(response);
                }
            }
        });
    });

    // ── Cancel button ──
    $('#cancelBtn').on('click', function () { resetForm(); });
});
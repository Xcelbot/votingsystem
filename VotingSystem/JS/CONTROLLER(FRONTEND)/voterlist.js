$(document).ready(function() {
    
    // 1. Function to load the voter list
    function loadVoters() {
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/vretrieve_users.php',
            type: 'GET',
            success: function(data) {
                $('#voterListData').html(data);
            }
        });
    }

    // Initial load
    loadVoters();

    // 2. SEARCH FILTER
    $('#voterSearch').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $("#voterListData tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // 3. POPULATE EDIT FORM
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let schoolid = $(this).data('schoolid');
        let fullname = $(this).data('fullname');
        let email = $(this).data('email');
        let course = $(this).data('course');
        let year = $(this).data('year');

        $('#v_user_id').val(id);
        $('#v_school_id').val(schoolid);
        $('#v_fullname').val(fullname);
        $('#v_email').val(email);
        $('#v_course').val(course);
        $('#v_year').val(year);

        // Enable the submit button and update text
        $('#submitBtn').text('UPDATE VOTER DETAILS').prop('disabled', false).css('background', '#2a5a2a');
        $('#formTitle').text('Editing: ' + fullname).css('color', '#fff');
        
        // Scroll to form on mobile
        $('html, body').animate({
            scrollTop: $("#voterForm").offset().top - 100
        }, 500);
    });

    // 4. SUBMIT EDIT FORM
    $('#voterForm').on('submit', function(e) {
        e.preventDefault();
        
        let id = $('#v_user_id').val();
        if (!id) {
            alert("No voter selected for editing.");
            return;
        }

        let btn = $('#submitBtn');
        let oldText = btn.text();
        btn.text('UPDATING...').prop('disabled', true);

        $.ajax({
            url: '../../CONTROLLER(BACKEND)/update.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.trim() === 'success') {
                    alert("Voter information updated!");
                    $('#voterForm')[0].reset();
                    $('#v_user_id').val('');
                    $('#submitBtn').text('SELECT A VOTER TO EDIT').prop('disabled', true).css('background', '#362e2e');
                    $('#formTitle').text('Edit Voter Information').css('color', '#ccc');
                    loadVoters();
                } else {
                    alert("Error: " + response);
                }
                btn.text(oldText).prop('disabled', false);
            },
            error: function() {
                alert("Could not connect to the update service.");
                btn.text(oldText).prop('disabled', false);
            }
        });
    });

    // 5. DELETE ACTION
    $(document).on('click', '.delete-btn', function() {
        let voterId = $(this).data('id');
        let voterName = $(this).data('name');

        if (confirm("Are you sure you want to remove " + voterName + "? This will permanently delete their account.")) {
            $.ajax({
                url: '../../CONTROLLER(BACKEND)/vdelete.php',
                type: 'POST',
                data: { user_id: voterId },
                success: function(response) {
                    if (response.trim() === 'success') {
                        loadVoters(); // Reload the table
                    } else {
                        alert("Error: " + response);
                    }
                },
                error: function() {
                    alert("Could not connect to deletion service.");
                }
            });
        }
    });

});
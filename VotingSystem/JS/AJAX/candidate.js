$(document).ready(function() {
    function loadTable() {
        $.ajax({
            url: '../PHP/cretrieve.php',
            type: 'GET',
            success: function(data) {
                $('#presidentData').html(data);
            }
        });
    }

    loadTable();

    // --- DELETE FUNCTION ---
    $(document).on('click', '.delete-btn', function() {
        var c_id = $(this).data('id'); // Gets ID from data-id attribute
        
        if (confirm("Are you sure you want to delete this candidate?")) {
            $.ajax({
                url: '../PHP/candidate.php',
                type: 'POST',
                data: { 
                    action: 'delete', 
                    candidate_id: c_id 
                },
                success: function(response) {
                    if (response.trim() == "success") {
                        alert("Deleted Successfully!");
                        loadTable(); // Refresh the list
                    } else {
                        alert(response);
                    }
                }
            });
        }
    });

    // --- EDIT FUNCTION (Fills the form) ---
     $(document).on('click', '.edit-btn', function() {
        // Get data from the button
        var id = $(this).data('id');
        var name = $(this).data('name');
        var course = $(this).data('course');
        var college = $(this).data('college');
        var pos = $(this).data('pos');

        // Put data into the form inputs (Matches your HTML IDs)
        $('#c_id').val(id);              // The hidden candidate_id
        $('#name_input').val(name);
        $('#course_select').val(course);
        $('#college_select').val(college);
        $('#pos_input').val(pos);

        // CHANGE MODE TO UPDATE
        $('#action_val').val('update');  // Changes the hidden 'action' input
        $('#btn').text('UPDATE');        // Changes the button text
        $('#cancelBtn').show();          // Show cancel if you have one
    });

    // --- 2. RESET FORM AFTER SUCCESS ---
    function resetForm() {
        $('#candidateForm')[0].reset();  // Clears all text/selects
        $('#c_id').val('');              // Clear hidden ID
        $('#action_val').val('add');     // Set mode back to add
        $('#btn').text('ADD');           // Change button back to ADD
        $('#cancelBtn').hide();
    }

    // --- 3. SUBMIT (Works for both Add and Update) ---
    $('#candidateForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../PHP/candidate.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
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
});
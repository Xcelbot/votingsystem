$(document).ready(function() {
    function loadTable() {
        $.ajax({
            url: '../CONTROLLER(BACKEND)/cretrieve.php',
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
           // Inside your candidate.js delete function
            $.ajax({
                url: '../CONTROLLER(BACKEND)/cdelete.php', // Pointing to the new script
                type: 'POST',
                data: { 
                candidate_id: c_id // This name must match the $_POST in PHP
                },
                    success: function(response) {
                    if (response.trim() == "success") {
                         alert("Candidate and their votes removed!");
                        loadTable(); 
                     } else {
                        alert(response);
                        }
                 }
            });
        }
    });

    // --- EDIT FUNCTION (Fills the form) ---
    $(document).on('click', '.edit-btn', function() {
    // 1. Extract data from the button that was clicked
    var id = $(this).data('id');
    var name = $(this).data('name');
    var course = $(this).data('course');
    var college = $(this).data('college');
    var pos = $(this).data('pos');

    // 2. Put that data into your form inputs
    $('#c_id').val(id);              
    $('#name_input').val(name);
    $('#course_select').val(course);
    $('#college_select').val(college);
    $('#pos_input').val(pos);

    // 3. Change form to Update Mode
    $('#action_val').val('update');  
    $('#btn').text('UPDATE');        
    $('#cancelBtn').show();          
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
            url: '../CONTROLLER(BACKEND)/candidate.php',
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
    // --- 4. CANCEL BUTTON CLICK ---
    $('#cancelBtn').on('click', function() {
        resetForm(); // Calls the function you already made!
    });
});
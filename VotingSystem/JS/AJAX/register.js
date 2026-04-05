$(document).ready(function() {
    
    // 1. DYNAMIC COURSE TOGGLE
    $('#college_select').on('change', function() {
        const selectedCollege = $(this).val(); 
        $('#course_select').val(""); 
        
        // Hide all optgroups
        $('#course_select optgroup').css('display', 'none'); 
        
        if (selectedCollege) {
            // Show group based on the college value
            $('#group-' + selectedCollege).css('display', 'block');
        }
    });

    // 2. AJAX SUBMISSION
    $('#regForm').on('submit', function(e) {
        e.preventDefault();

        // Local Password Match Check
        if ($('#pass').val() !== $('#cpass').val()) {
            alert("Passwords do not match!");
            return;
        }

        $('#btn').text('Processing...').prop('disabled', true);

             $.ajax({
            type: 'POST',
            url: '../PHP/register.php',
            data: $(this).serialize(),
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Account successfully created!");
                    location.reload(); 
                } else {
                    alert(response);
                    $('#btn').text('REGISTER').prop('disabled', false);
                }
            }
        });
    });
});

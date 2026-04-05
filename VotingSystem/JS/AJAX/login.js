$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        $('#loginBtn').text('Authenticating...').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: '../PHP/login.php',
            data: $(this).serialize(),
            success: function(response) {
                let res = response.trim();

                // 1. FIXED: Manual Redirect
                if (res === "success") {
                    window.location.href = '../PHP/redirect.php';
                } 
                // 2. Handle Already Voted
                else if (res === "already_voted") {
                    alert("Access Denied: You have already cast your vote.");
                    resetLogin();
                }
                // 3. Handle Errors
                else {
                    alert(res); 
                    resetLogin();
                }
            },
            error: function() {
                alert("An error occurred on the server.");
                resetLogin();
            }
        });
    });

    function resetLogin() {
        $('#loginForm')[0].reset(); 
        $('#loginBtn').text('LOGIN').prop('disabled', false);
    }
});
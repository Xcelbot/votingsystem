$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        $('#loginBtn').text('Authenticating...').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: '../CONTROLLER(BACKEND)/login.php',
            data: $(this).serialize(),
            success: function(response) {
                let res = response.trim();

                if (res === "success") {
                    // This triggers the redirect logic
                    window.location.href = '../CONTROLLER(BACKEND)/redirect.php';
                } 
                else if (res === "already_voted") {
                    alert("Access Denied: You have already cast your vote.");
                    resetLogin();
                }
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
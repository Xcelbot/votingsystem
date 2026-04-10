$(document).ready(function () {
    // START Button interaction
    $(document).on('click', '#startPollBtn', function () {
        // We can add logic here like checking if the election is active before redirecting
        window.location.href = 'login.html';
    });
});

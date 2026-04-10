$(document).ready(function() {
    
    // 1. LOAD & SEARCH: Fetch the categorized tables
    function loadManagementList(searchTerm = '') {
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/info.php', // Fetches your styled tables
            type: 'GET',
            data: { search: searchTerm },
            success: function(data) {
                // Injects the HTML (Admins, Officers, Voters, Auditors)
                $('#managementListContainer').html(data);
            },
            error: function() {
                console.error("Could not load info.php. Check file path.");
            }
        });
    }

    // Initial load on page start
    loadManagementList();

    // 2. SEARCH ACTION
    $('#searchBtn').on('click', function() {
        let term = $('#searchInput').val();
        loadManagementList(term);
    });

    // 3. VIEW BUTTON: Switch to Edit Form
    // Using delegated events because buttons are created dynamically
    $(document).on('click', '.view-btn', function() {
        let id = $(this).data('id');

        $.post('../../CONTROLLER(BACKEND)/userinfo.php', { user_id: id }, function(formHtml) {
            // Hide the tables and show the Registration-style form
            $('#listView').hide();
            $('#editView').html(formHtml).fadeIn();
        });
    });

    // 4. BACK/EXIT BUTTON (Inside the generated form)
    $(document).on('click', '#backBtn', function() {
        $('#editView').hide();
        $('#listView').fadeIn();
        loadManagementList(); // Refresh list to show any changes
    });

    // 5. SAVE CHANGES: Submit the update form
    $(document).on('submit', '#updateForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/update.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.trim() === "success") {
                    alert("Information Updated Successfully!");
                    $('#backBtn').click(); // Return to the list view
                } else {
                    alert("Error: " + res);
                }
            }
        });
    });

    // 6. DELETE ACTION: Remove user and auto-refresh
    $(document).on('click', '.del-btn', function() {
        let id = $(this).data('id');
        
        if (confirm("Are you sure you want to permanently delete this user?")) {
            $.post('../../CONTROLLER(BACKEND)/delete.php', { user_id: id }, function(res) {
                if (res.trim() === "success") {
                    loadManagementList(); // Instant refresh of the tables
                } else {
                    alert("Delete failed: " + res);
                }
            });
        }
    });
});

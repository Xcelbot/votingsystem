$(document).ready(function () {

    // Restore Button
    $(document).on('click', '.btn-restore', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        if (confirm("Restore this candidate back to the active list?")) {
            $.post('../CONTROLLER(BACKEND)/archive.php', { archive_id: id, action: 'restore' }, function (res) {
                var response = res.trim();
                if (response === "success") {
                    alert("Candidate successfully restored!");
                    row.fadeOut(400, function () { $(this).remove(); });
                } else {
                    alert("Error: " + response);
                }
            });
        }
    });

    // Permanent Delete Button
    $(document).on('click', '.btn-perm-delete', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        if (confirm("Permanently delete this candidate? This CANNOT be undone.")) {
            $.post('../CONTROLLER(BACKEND)/archive.php', { archive_id: id, action: 'permanent_delete' }, function (res) {
                var response = res.trim();
                if (response === "success") {
                    alert("Candidate permanently deleted.");
                    row.fadeOut(400, function () { $(this).remove(); });
                } else {
                    alert("Error: " + response);
                }
            });
        }
    });

});
$(document).ready(function() {
    $('#feedback').click(function() {
        $('#feedbackModal').modal('show');
    });

    $('#feedbackForm').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: 'feedback.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Response:', response);
                let alertType = response.success ? 'alert-success' : 'alert-danger';
                $('#feedback-message').html('<div class="alert ' + alertType + '">' + response.message + '</div>');

                if (response.success) {
                    $('#feedbackForm')[0].reset();
                    setTimeout(function() {
                        $('#feedbackModal').modal('hide');
                        $('#feedback-message').html('');
                    }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                $('#feedback-message').html('<div class="alert alert-danger">An error occurred while submitting feedback.</div>');
            }
        });
    });
});

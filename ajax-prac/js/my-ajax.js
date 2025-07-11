jQuery(document).ready(function($) {
    $('#load-post-title').on('click', function() {
        $.ajax({
            url: my_ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'load_random_post_title',
                security: my_ajax_obj.nonce
            },
            success: function(response) {
                $('#result').html(response);
            },
            error: function(error) {
                $('#result').html('Something went wrong.');
            }
        });
    });
});

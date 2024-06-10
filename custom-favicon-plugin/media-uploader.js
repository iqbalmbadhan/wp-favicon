jQuery(document).ready(function($) {
    var mediaUploader;
    $('#myplugin_favicon_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Select Favicon',
            button: {
                text: 'Select Favicon'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#myplugin_favicon_id').val(attachment.id);
            $('#myplugin_favicon_preview').attr('src', attachment.url).show();
        });
        mediaUploader.open();
    });

    var mediaUploaderApple;
    $('#myplugin_apple_touch_icon_button').click(function(e) {
        e.preventDefault();
        if (mediaUploaderApple) {
            mediaUploaderApple.open();
            return;
        }
        mediaUploaderApple = wp.media.frames.file_frame = wp.media({
            title: 'Select Apple Touch Icon',
            button: {
                text: 'Select Apple Touch Icon'
            },
            multiple: false
        });
        mediaUploaderApple.on('select', function() {
            var attachment = mediaUploaderApple.state().get('selection').first().toJSON();
            $('#myplugin_apple_touch_icon_id').val(attachment.id);
            $('#myplugin_apple_touch_icon_preview').attr('src', attachment.url).show();
        });
        mediaUploaderApple.open();
    });
});

$(function () {
    
    // Avatar upload form
    $('.avatar-form').ajaxForm({

        url: Ajaxrequest() + '?t=avatar&a=new', 
        beforeSend: function() {
            form = $('.avatar-form');
            avatar_btn = form.find('#avatar-btn');
            image_loader = $('.gamemonetize-loader');
            uploadInput  = $('.avatar-upload-door');
            image_loader.show();
            avatar_btn.attr('disabled', true);
        },
        success: function(data) {
            image_loader.hide();
            $('.loading').remove();

            if (data.status == 200) {
                Toast.success(data.success_message);
                $('.gamemonetize-avatar').attr('src', data.avatar_url);
                uploadInput.replaceWith(uploadInput.val('').clone(true));
            }
            else {
                Toast.error(data.error_message);
                uploadInput.replaceWith(uploadInput.val('').clone(true));
            }
            avatar_btn.attr('disabled', false);
        }
    });

    // Configuration setting form
    $('form.update-user-info').ajaxForm({
        url: Ajaxrequest()+'?t=user&a=info',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
            else {
                Toast.error(data.error_message);
            }
        },
        error: function() {
            Toast.error('Error connecting to server...');
        }
    });

    // Theme setting form
    $(document).on('click', '#theme-check', function(){
        $('.theme_active').removeClass('theme_active');
        var __tCL = $(this);
        var __tCL_dt = $(__tCL).attr('data-theme-id');
        $('.theme-chk-'+__tCL_dt).addClass('theme_active');
    });

    $('form.theme-form').ajaxForm({
        url: Ajaxrequest()+'?t=user&a=update_theme',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
        },
        error: function() {
            Toast.error('Error connecting to server...');
        }
    });

    // Change Password form
    $('form.update-user-password').ajaxForm({
        url: Ajaxrequest()+'?t=user&a=password',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
            else {
                Toast.error(data.error_message);
            }
        },
        error: function() {
            Toast.error('Error connecting to server...');
        }
    });

    // Favorite
    $(document).ready(function(){
        $(document).on('click', '#fav-btn', function(){
            ajaxFav($(this).attr('data-game'));
        });

        function ajaxFav(game_id) {
            $.ajax({
                url: Ajaxrequest() + '?t=update_favourite',
                type: 'POST',
                data: "id=" + game_id,
                success: function(data) {
                    favorite_id = $('#fav-btn');
                    if (favorite_id.hasClass('fav-added')) {
                        favorite_id.removeClass('fav-added');
                    } else {
                        favorite_id.addClass('fav-added');
                        swal({
                            title: null,
                            text: data.success_message,
                            timer: 2300,
                            html: true
                        });
                    }
                }
            });
        }
    });

});
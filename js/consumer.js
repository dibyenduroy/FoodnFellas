jQuery(
    $(function(){
    $.ajax({
        url: '../php/ConsumerProfile.php',                  //the script to call to get data
        crossDomain: true,
        dataType: 'jsonp',                //data format
        type: 'GET',
        success: function(data)
        {
            var data = data[0];

            //if (!$('#user_id')) {
            if (true) {
                $("#userNameOrLogin").prepend('<li><a href="/login" data-toggle="modal" '+
                    'data-target=".social-login-modal">Login</a></li>');
                $("#userNameOrLogin").prepend('<li><a href="/signup" data-toggle="modal" '+
                    'data-target=".social-signup-modal">Sign Up</a></li>');
            }
            $('#firstName').val("dummy first name");
            $('#lastName').val("dummy last name");
            $('#aboutMe').val(data['about_me']);
            $('#favoriteDish').val(data['my_fav_dish']);
            $('#email').val("dummy email");
            $('#phoneNumber').val(data['phone_number']);

            if (data['photo']) {
                //replace the photo
                var image = $('#profile_image')[0];
                image.src = data['photo'];
                image.style.height = '200px';
                image.style.width = '200px';
            }
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
    })
);

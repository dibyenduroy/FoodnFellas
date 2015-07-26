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

            if (!data['user_id']) { //if no user id, show blank page with sign up and login btns
                $("#userNameOrLogin").prepend('<li><a href="/login" data-toggle="modal" '+
                    'data-target=".social-login-modal">Login</a></li>');
                $("#userNameOrLogin").prepend('<li><a href="/signup" data-toggle="modal" '+
                    'data-target=".social-signup-modal">Sign Up</a></li>');
            } else {
                // Show user ID in the navbar
                $("#userNameOrLogin").prepend('<li id="logout-btn"><button type="button" class="btn btn-default">'+
                    '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Logout'+
                    '</button></li>');
                $("#userNameOrLogin").prepend('<li id="userId"> Signed in as '+ data["user_id"] +'</li>');

                //add logout btn

                // fill in the form with existing user data.
                $('#firstName').val("dummy first name");
                $('#lastName').val("dummy last name");
                $('#aboutMe').val(data['about_me']);
                $('#favoriteDish').val(data['my_fav_dish']);
                $('#email').val("dummy email");
                $('#phoneNumber').val(data['phone_number']);

                // display user profile photo
                if (data['photo']) {
                    //replace the photo
                    var image = $('#profile_image')[0];
                    image.src = data['photo'];
                    image.style.height = '200px';
                    image.style.width = '200px';
                }
            }
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
    })
);

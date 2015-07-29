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
                $('#Name').val(data['f_name']).val(data['l_name']);
                $('#AboutMe').val(data['about_me']);
                $('#AwardsWon').val(data['awards_won']);
                $('#Cuisine_I_Cook').val(data['cuisine_i_cook']);
                $('#price_per_person').val(data['price_per_person']);
                $('#delivery_method').val(data['delivery_method']);
                $('#').val(data['available_start']).val(data['available_end']);
                $('#dish_name').val(data['dish_name']);
                $('#meal_description').val(data['meal_description']);


                // display  profile photos and other photos.
                if (data['photo']) {
                    //replace the photo
                    var image = $('#profile_image')[0];
                    image.src = data['photo'];
                    image.style.height = '200px';
                    image.style.width = '200px';
                }
                if (data['kitchen_photo']) {
                    //replace the photo
                    var image = $('#kitchen_photo')[0];
                    image.src = data['kitchen_photo'];
                    image.style.height = '200px';
                    image.style.width = '200px';
                }
                if (data['food_album']) {
                    //replace the photo
                    var image = $('#food_album')[0];
                    image.src = data['food_album'];
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

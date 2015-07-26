jQuery(
    $(function(){
    $.ajax({
        url: '../php/ConsumerProfile.php',                  //the script to call to get data
        crossDomain: true,
        dataType: 'jsonp',                //data format
        type: 'GET',
        success: function(data)
        {
            $('#firstName').val("dummy first name");
            $('#lastName').val("dummy last name");
            $('#aboutMe').val(data[0]['about_me']);
            $('#favoriteDish').val(data[0]['my_fav_dish']);
            $('#email').val("dummy email");
            $('#phoneNumber').val(data[0]['phone_number']);

            if (data[0]['photo']) {
                //replace the photo
                $('#profile_image').src = data[0]['photo'];
                $('#profile_image').style.height = '200px';
                $('#profile_image').style.width = '200px';
            }
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
    })
);

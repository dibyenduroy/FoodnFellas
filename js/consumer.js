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
            $('#firstName').val("dummy first name");
            $('#lastName').val("dummy last name");
            $('#aboutMe').val(data['about_me']);
            $('#favoriteDish').val(data['my_fav_dish']);
            $('#email').val("dummy email");
            $('#phoneNumber').val(data['phone_number']);

            if (data['photo']) {
                //replace the photo
                var image = $('#profile_image')[0];
                image.src = data[0]['photo'];
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

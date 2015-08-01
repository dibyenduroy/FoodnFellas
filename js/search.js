function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(function() {
    //set the where, numpeople, and when from previous page
    $('#where').val(getParameterByName('where'));
    $('#when').val(getParameterByName('when'));
    $('#numPeople').val(getParameterByName('numPeople'));

    // calendar date picker
    $( "#when" ).datepicker();

    //create slider range for price
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 100,
        values: [ 5, 30 ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - $" + $( "#slider-range" ).slider( "values", 1 ) );

    // set the value and text of the dropdown menu upon user selection
    $("#meal-requirement-dropdown li a").click(function(){
        $("#meal-requirement-btn").text($(this).text());
        $("#mael-requirement-btn").val($(this).text());
    });
    $("#cuisine-type-dropdown li a").click(function(){
        $("#cuisine-type-btn").text($(this).text());
        $("#cuisine-type-btn").val($(this).text());
    });
    $("#delivery-method-dropdown li a").click(function(){
        $("#delivery-method-btn").text($(this).text());
        $("#delivery-method-btn").val($(this).text());
    });
    $("#allergies1-dropdown li a").click(function(){
        $("#allergies1-btn").text($(this).text());
        $("#allergies1-btn").val($(this).text());
    });
    $("#allergies2-dropdown li a").click(function(){
        $("#allergies2-btn").text($(this).text());
        $("#allergies2-btn").val($(this).text());
    });

});

jQuery(
    $(function(){
    $.ajax({
        url: '../php/search.php',                  //the script to call to get data
        crossDomain: true,
        dataType: 'jsonp',                //data format
        type: 'GET',
        success: function(data)
        {
                    //console.log('inside success');
                    //console.log(data);
                    //TODO: need to check if sign up was successful (data should have status -- fix PHP)
                    
                    //alert("Sign up was succesful")
            // Now the count is in data[0], so we look in data[1]
           // var data = data[1];
            /*if (!data['user_id']) { //if no user id, show blank page with sign up and login btns
                $("#userNameOrLogin").prepend('<li><a href="/login" data-toggle="modal" '+
                    'data-target=".social-login-modal">Login</a></li>');
                $("#userNameOrLogin").prepend('<li><a href="/signup" data-toggle="modal" '+
                    'data-target=".social-signup-modal">Sign Up</a></li>');
            } else {
                // Show user ID in the navbar
                $("#userNameOrLogin").prepend('<li id="logout-btn"><button type="button" class="btn btn-default">'+
                    '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Logout'+
                    '</button></li>');
                $("#userNameOrLogin").prepend('<li id="userId"> Signed in as '+ data["user_id"] +'</li>');*/

                //add logout btn

                // fill in the form with existing user data.
               // $('#Name').val(data['f_name']).val(data['l_name']);
                location.href='../html/search_results.html';
                $('#AboutMe').val(data['count']);
                /*$('#AwardsWon').val(data['awards_won']);
                $('#Cuisine_I_Cook').val(data['cuisine_i_cook']);
                $('#price_per_person').val(data['price_per_person']);
                $('#delivery_method').val(data['delivery_method']);
                $('#available_on').val(data['available_start']).val(data['available_end']);
                $('#dish_name').val(data['dish_name']);
                $('#meal_description').val(data['meal_description']);
                */


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



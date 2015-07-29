$( "#datepicker" ).datepicker();

function providerBtnCallBack() {
    location.href='/html/provider.html';
}

function redirectToHomePage() {
    // get the user id back from the registration.php
    // get the user data back from the consumer.php (see how consumer.js) does this
    // if the user data exists, in database
    // then reload index_afterlaunch.html with the
    //login info

    //location.href='index_afterlaunch.html';
}

jQuery(
    $(function(){
        $.ajax({
            url: '../php/registration.php',                  //the script to call to get data
            crossDomain: true,
            dataType: 'jsonp',                //data format
            type: 'GET',
            success: function(data)
            {
                console.log('inside success');
                console.log(data);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });
    })
);

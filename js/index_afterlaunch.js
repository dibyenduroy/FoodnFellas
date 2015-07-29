$( "#datepicker" ).datepicker();

function providerBtnCallBack() {
    location.href='/html/provider.html';
}

//function redirectToHomePage() {
//    // get the user id back from the registration.php
//    // get the user data back from the consumer.php (see how consumer.js) does this
//    // if the user data exists, in database
//    // then reload index_afterlaunch.html with the
//    //login info
//
//    //location.href='index_afterlaunch.html';
//}

function signupCallBack() {
    jQuery(
        $(function () {
            $.ajax({
                url: '../php/registration.php',   //the script to call to get data
                crossDomain: true,
                dataType: 'jsonp',                //data format
                type: 'GET',
                success: function (data) {
                    console.log('inside success');
                    console.log(data);
                    //TODO: need to check if sign up was successful (data should have status -- fix PHP)
                    location.href='index_afterlaunch.html';
                    alert("Succesful Login")
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert("Sign up was unsucessful. Please try again");
                }
            });
        })
    );
}

function loginCallBack() {
    jQuery(
        $(function () {
            $.ajax({
                url: '../php/login_v2.php',   //the script to call to get data
                crossDomain: true,
                dataType: 'jsonp',                //data format
                type: 'GET',
                success: function (data) {
                    console.log('inside success');
                    console.log(data);
                    location.href='index_afterlaunch.html';
                    alert("Successful Login");
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert("Unsuccessful login. Please try again");
                }
            });
        })
    );
}
$( "#datepicker" ).datepicker();

function providerBtnCallBack() {
    location.href='/html/provider.html';
}


$('#search-btn').submit(function(ev) {
    ev.preventDefault(); // to stop the form from submitting
    /* Validations go here */
    this.submit(); // If all the validations succeeded
    //redirect to search
    location.href='./html/search.html?date=10_05_2015';

});

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
                    alert("Sign up was succesful")
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    location.href='index_afterlaunch.html';
                    alert("Sign up was failed. Please try again");
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
                    location.href='index_afterlaunch.html';
                    alert("Unsuccessful login. Please try again");
                }
            });
        })
    );
}
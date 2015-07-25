$(function ()
{    //-----------------------------------------------------------------------
    // 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
    //-----------------------------------------------------------------------
    $.ajax({
        url: '../php/ProviderProfile.php',                  //the script to call to get data
        data: "",                        //you can insert url argumnets here to pass to api.php
                                         //for example "id=5&parent=6"
        dataType: 'json',                //data format
        success: function(data)          //on recieve of reply
        {
            console.log("data is ", data);
            /*
            var firstName = data[0];              //get id
            var lastName = data[1];           //get name
            var email = data[2];
            var password = data[3];
            var login_type = data[4];

            //--------------------------------------------------------------------
            // 3) Update provider content
            //--------------------------------------------------------------------
            $('firstName').value = firstName;
            $('lastName').value = lastName;
            $('email').value = email;
            $('password').value = password;
            $('login_type').value = login_type;
            */
        }
    });
});
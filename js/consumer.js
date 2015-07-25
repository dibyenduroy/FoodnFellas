$.ajax({
    url: 'http://foodnfellas.com/php/ConsumerProfile.php',                  //the script to call to get data
    crossDomain: true,
    dataType: 'jsonp',                //data format
    success: function(data)          //on recieve of reply
    {
        console.log("data is ", data);
        /*
         var firstName = data[0];              //get id
         var lastName = data[1];           //get name
         var aboutMe = data[2];
         var favoriteDish = data[3];
         var email = data[4];
         var phoneNumber = data[5];
         //--------------------------------------------------------------------
         // 3) Update provider content
         //--------------------------------------------------------------------
         $('firstName').value = firstName;
         $('lastName').value = lastName;
         $('aboutMe').value = aboutMe;
         $('favoriteDish').value = favoriteDish;
         $('email').value = email;
         $('phoneNumber').value = phoneNumber;
         */
    },
    error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
    }
});

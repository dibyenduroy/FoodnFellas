jQuery(
    $(function() {
        $( "#when" ).datepicker();


        //$('#login-btn').submit(function() {
        //    loginOnSubmit();
        //});
    })
);

function searchBtnCallBack() {
    //TODO: do validation
    // get the values in the form
    var where = $("#where").val();
    var when = $("#when").val();
    var numPeople = $("#numPeople").val();
    // encode the special chars for the url query string
    where = encodeURI(where);
    when = encodeURI(when);
    numPeople = encodeURI(numPeople);
    location.href='./html/search.html?'
        + 'where=' + where + '&when='
        + when + '&numPeople=' + numPeople;
}

function providerBtnCallBack() {
    location.href='./html/provider.html';
}


function signupCallBack() {
    jQuery(
        $(function () {
            $.ajax({
                url: './php/registration.php',   //the script to call to get data
                crossDomain: true,
                dataType: 'jsonp',                //data format
                type: 'GET',
                success: function (data) {
                    console.log('inside success');
                    console.log(data);
                    //TODO: need to check if sign up was successful (data should have status -- fix PHP)
                    //location.href='index_afterlaunch.html';
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

//function login_as_user() {
//    jQuery(
//        $(function() {
//            console.log(document.cookie);
//            var ca = document.cookie.split('+');
//            for(var i=0; i<ca.length; i++) {
//                var c = ca[i];
//                while (c.charAt(0)==' ') c = c.substring(1);
//                if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
//            }
//        })
//    );
//}

function loginCallBack() {
    $.ajax({
        url: 'php/login_v2.php',
        data: {name: 'Chad'},
        dataType: 'jsonp',
        jsonp: 'callback',
        crossDomain: true,
        success: function(){
            alert("success");
        }, error: function(xhr, status, error) {
            alert("failure!");
        }
    });
    //jQuery(
    //    $(function () {
    //        $.ajax({
    //            url: 'php/login_v2.php',   //the script to call to get data
    //            crossDomain: true,
    //            dataType: 'jsonp',                //data format
    //            jsonp: 'callback',
    //            success: function (data) {
    //                console.log('inside success');
    //                console.log(data);
    //                //location.href='index_afterlaunch.html';
    //                alert("Successful Login");
    //            },
    //            error: function (xhr, status, error) {
    //                var err = eval("(" + xhr.responseText + ")");
    //                console.log(err);
    //                //location.href='index_afterlaunch.html';
    //                alert("Unsuccessful login. Please try again");
    //            }
    //        });
    //    })
    //);
}
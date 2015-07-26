$("document").ready(function(){
    $(".js-ajax-php-json").submit(function(){
        var data = {
            "action": "test"
        };

        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "./registration.php", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                $(".the-return").html(
                    "Post Status: " + data["Status"] + "<br />JSON: " + data["json"]
                );
                console.log("data[status] ", data["Status"]);
                console.log("data[json]", data["json"]);
                alert("Form submitted successfully.\nReturned json: " + data["json"]);
            }
        });
        return false;
    });
});

// GP login
/**
 * Handler for the signin callback triggered after the user selects an account.
 */
function onSignInCallback(resp) {
    gapi.client.load('plus', 'v1', apiClientLoaded);
}

/**
 * Sets up an API call after the Google API client loads.
 */
function apiClientLoaded() {
    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
}

/**
 * Response callback for when the API client receives a response.
 *
 * @param resp The API response object with the user email and profile information.
 */
function handleEmailResponse(resp) {
    var primaryEmail;
    for (var i=0; i < resp.emails.length; i++) {
        if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
    }
    document.getElementById('responseContainer').value = 'Primary email: ' +
        primaryEmail
        +'\n\nName:'+  resp.displayName

        +'\n\nFull Response:\n' + JSON.stringify(resp);
}

//Fb login

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log('>>>>'+response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
        // Logged into your app and Facebook.

        console.log('>>>>'+ response.authResponse.userID);

        //testAPI();
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
    }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

window.fbAsyncInit = function() {
    FB.init({
        appId      : '1596588203933528',
        cookie     : true,  // enable cookies to allow the server to access
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.2', // use version 2.2
        oauth      : true,
        redirect_uri: 'http://www.foodnfellas.com/FB.html'
    });

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });

};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "http://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        console.log('Successful login for: ' + response.name);
        document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + response.email +':'+response.id+':'+response.userID+ '!';
    });
}
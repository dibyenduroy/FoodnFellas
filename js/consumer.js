$.ajax({
    url: 'http://foodnfellas.com/php/ConsumerProfile.php',                  //the script to call to get data
    crossDomain: true,
    dataType: 'jsonp',                //data format
    success: function(data)          //on recieve of reply
    {
    },
    error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
    }
});

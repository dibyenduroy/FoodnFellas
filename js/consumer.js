$(function(){
    $.ajax({
        url: 'http://foodnfellas.com/php/ConsumerProfile.php',                  //the script to call to get data
        crossDomain: true,
        dataType: 'jsonp',                //data format
        type: 'get',
        success: function(data)          //on recieve of reply
        {
            console.log('success');
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
});


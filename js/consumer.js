jQuery(
    $(function(){
        $.ajax({
            url: 'http://foodnfellas.com/php/ConsumerProfile.php',                  //the script to call to get data
            crossDomain: true,
            dataType: 'jsonp',                //data format
            type: 'GET'
        }).done(function(response){
                console.log(response);
        }).fail(function(error){
            console.log(error.statusText);
        });
    })
);

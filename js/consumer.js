jQuery(
    $(function(){
    $.ajax({
        url: '../php/ConsumerProfile.php',                  //the script to call to get data
        crossDomain: true,
        dataType: 'jsonp',                //data format
        type: 'GET',
        success: function(data)          //on recieve of reply
        {
            console.log(JSON.stringify(data));
            console.log('success');
            //$('.results').html(JSON.stringify(data));
            $('#firstName').val(JSON.stringify(data));
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
    })
);

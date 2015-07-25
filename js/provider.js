$(function ()
{
    //-----------------------------------------------------------------------
    // 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
    //-----------------------------------------------------------------------
    $.ajax({
        url: 'api.php',                  //the script to call to get data
        data: "",                        //you can insert url argumnets here to pass to api.php
                                         //for example "id=5&parent=6"
        dataType: 'json',                //data format
        success: function(data)          //on recieve of reply
        {
            var id = data[0];              //get id
            var vname = data[1];           //get name
            //--------------------------------------------------------------------
            // 3) Update html content
            //--------------------------------------------------------------------
            $('#output').html("<b>id: </b>"+id+"<b> name: </b>"+vname); //Set output element html
            //recommend reading up on jquery selectors they are awesome
            // http://api.jquery.com/category/selectors/
        }
    });
});
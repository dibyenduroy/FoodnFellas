function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(function() {
    //set the where, numpeople, and when from previous page
    $('#where').val(getParameterByName('where'));
    $('#when').val(getParameterByName('when'));
    $('#numPeople').val(getParameterByName('numPeople'));

    // calendar date picker
    $( "#when" ).datepicker();

    //create slider range for price
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 100,
        values: [ 5, 30 ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - $" + $( "#slider-range" ).slider( "values", 1 ) );

    // set the value and text of the dropdown menu upon user selection
    $("#meal-requirement-dropdown li a").click(function(){
        $("#meal-requirement-btn").text($(this).text());
        $("#mael-requirement-btn").val($(this).text());
    });
    $("#cuisine-type-dropdown li a").click(function(){
        $("#cuisine-type-btn").text($(this).text());
        $("#cuisine-type-btn").val($(this).text());
    });
    $("#delivery-method-dropdown li a").click(function(){
        $("#delivery-method-btn").text($(this).text());
        $("#delivery-method-btn").val($(this).text());
    });
    $("#allergies1-dropdown li a").click(function(){
        $("#allergies1-btn").text($(this).text());
        $("#allergies1-btn").val($(this).text());
    });
    $("#allergies2-dropdown li a").click(function(){
        $("#allergies2-btn").text($(this).text());
        $("#allergies2-btn").val($(this).text());
    });
});


function gotoSearchResult(){
    location.href='../html/search_results.html';
}

$( "#datepicker" ).datepicker();

$(function() {
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
});
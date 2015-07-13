$('#foo').slider()
    .on('slide', function(ev){
        $('#bar').val(ev.value);
    });
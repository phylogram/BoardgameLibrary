alert("javascript is working");


$(document).ready(function(){
    var pieces = new Array();
    $("svg").click(function() {

        var piece_name = $(this).attr("id");
        var offset = $(this).offset();

        if (!pieces[piece_name]) {
            pieces[piece_name] = 1;
        }
        if (pieces[piece_name] === 1) {

            var background2 = "#bfe998";
            var background1 = "#93a6ee";
            pieces[piece_name] = -1;

            var incrementor = 70;
        } else {
            var background1 = "$bg1";
            var background2 = "$bg2";
            pieces[piece_name] = 1;
            var incrementor = 0;
        }

        $.post("http://boardgame.dev/Play", {
                data: {'possible_moves': piece_name},
                dataType: 'json'
            },
            function(data, status) {

                var data = JSON.parse(data);
                var miliseconds = 0;
                data.forEach(function(item, index){
                    var field = $('#' + item);
                    setTimeout(function(){

                        if (field.hasClass("$bg1")) {
                            field.css("background-color", background1);
                        } else {
                            field.css("background-color", background2);
                        }
                    }, miliseconds);
                    miliseconds += incrementor;
                });
            }
        );
    })
    $('svg').draggable( {
        containment: 'table',
    } );
    $('td').droppable( {
        drop: handleDropEvent,
        revert: true

    } );



    function handleDropEvent( event, ui ) {
        var draggable = ui.draggable.attr('id');
        var dropable = event.target.id;
        ui.draggable.position( { of: $(this), my: 'center center', at: 'center center' } );
        pieces[draggable] = -1;

        $.post("http://boardgame.dev/Play", {
                data: { 'moving_piece': draggable,
                    'target_field': dropable,
                    'override': false
                },
                dataType: 'json'
            }, function(data, status) {
                var data = JSON.parse(data);
                alert(data['success']);
            }
        );
    }
});
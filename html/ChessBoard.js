$(document).ready(function() {
    var pieces = new Array();
    $("svg").click(function () {

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
            var background1 = '#999';
            var background2 = '#fff';
            pieces[piece_name] = 1;
            var incrementor = 0;
        }

        $.post("http://boardgame.dev/PlayExample", {
                data: {'possible_moves': piece_name},
                dataType: 'json'
            },
            function (data, status) {

                var data = JSON.parse(data);
                var milliseconds = 0;
                data.forEach(function (item, index) {
                    var field = $('#' + item);
                    setTimeout(function () {

                        if (field.hasClass('#999')) {
                            field.css("background-color", background1);
                        } else {
                            field.css("background-color", background2);
                        }
                    }, milliseconds);
                    milliseconds += incrementor;
                });
            }
        );
    })
    $('svg').draggable({
        containment: 'table'
    });
    $('td').droppable({
        drop: handleDropEvent

    });

    function sendMove(moving_piece, target_field, override) {

        $.post("http://boardgame.dev/PlayExample", {
            dataType: 'json',
            success: 'JSON.parse',
            data: {
                'moving_piece': moving_piece,
                'target_field': target_field,
                'override': override
            }
        },function (data){

            var data = JSON.parse(data);
            if (data['success'] != true) {
                override = prompt(data['success'] + '\nIf you want to continue, please type in your Credit Card Number:', '666');
                override = override == 666;
                if (override) {
                    sendMove(
                        data['client_moving_piece'],
                        data['client_target_field'],
                        true
                    );
                } else {
                    var move_back = $('#' + data['client_moving_piece']);
                    var position = $('#' + data['client_start_field']);
                    move_back.appendTo(position);
                    move_back.position({of: $(position), my: 'center center', at: 'center center'});
                }
            } else {
                move(data);
            }
        })
        }



    function move(data) {
        var piece = $('#' + data['computer_moving_piece']);
        var target_field = $('#' + data['computer_target_field']);
        target_field.append(piece);
        piece.position({of: $(target_field), my: 'center center', at: 'center center'});
    }

    function handleDropEvent(event, ui) {
        var draggable = ui.draggable.attr('id');
        var dropable = event.target.id;
        pieces[draggable] = -1;
        /*So the show fields function is not invoked when dragging*/
        sendMove(draggable, dropable, false);
    }

});
$(document).ready(function() {
        var availableTags = [
            'bishop black',
            'bishop white',
            'king black',
            'king white',
            'knight black',
            'knight white',
            'pawn black',
            'pawn white',
            'queen black',
            'queen white',
            'rook black',
            'rook white'
        ];

    $('td').droppable({
        drop: handleDropEvent
    });
        $('.choose_game').button();
        $("#tags1").autocomplete({
            source: availableTags,
            select: function (event, ui) {
                    var name = ui.item.label;
                    var type = 'moving';
                    $.post("http://boardgame.dev/SelectBoard",
                        {data: {
                            'required_pieces': {
                                name: name,
                                type: type
                            }
                        }
                        }, function (data) {
                            $('#doc_IteratorClasses').append('<p>' + data + '</p>');
                            $('svg').draggable();
                        }
                    )

            }
        });
        $("#tags2").autocomplete({
            source: availableTags,
            select: function (event, ui) {
                var name = ui.item.label;
                var type = 'reclining';
                $.post("http://boardgame.dev/SelectBoard",
                    {data: {
                        'required_pieces': {
                            name: name,
                            type: type
                        }
                    }
                    }, function (data) {
                        $('#doc_IteratorClasses').append('<p>' + data + '</p>');
                        $('svg').draggable();
                    }
                )
            }
            });
    function handleDropEvent(event, ui) {
        var draggable = ui.draggable.attr('id');
        var dropable = event.target.id;

        /*So the show fields function is not invoked when dragging*/

        sendMove(draggable, dropable);
    }

    function sendMove(moving_piece, target_field) {
        $.post("http://boardgame.dev/SelectBoard", {
            data: {
                'required_moves': {
                    'moving_piece': moving_piece,
                    'target_field': target_field
                }
            }
        }, function (data) {

            $('#chooseANDresult').append(data);
            });
    }

})
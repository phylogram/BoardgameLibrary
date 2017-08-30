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
            'rook black,',
            'rook white'
        ];
        $('#choose_piece').button();
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
                        }
                    )

            }
        });
        var reclining_move = $("#tags2").autocomplete({
            source: availableTags,
            select: function (event, ui) {
                return ui.item.label;
            }
        });



    }
)
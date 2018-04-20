/**
 * Plantilla para responder a nuevo comentario
 */
var commentTemplate = 
'<div class="columns">' +
    '<div class="column is-11 is-offset-1">' +
        '<article class="media is-response">' +
            '<div class="media-content">' +
                '<textarea id="contenido" name="contenido" rows="1" class="textarea" placeholder="Respuesta..."></textarea>' +
                '<br>' +
                '<div class="level">' +
                    '<div class="level-left"></div>' +
                    '<div class="level-right">' +
                        '<button class="button level-item is-success is-small response">' +
                            '<span class="icon">' +
                                '<i class="fa fa-commenting-o" aria-hidden="true"></i>' +
                            '</span>' +
                            '<span>Responder</span>' +
                        '</button>' +
                        '<button class="button level-item is-danger is-small cancel">' +
                            '<span class="icon">' +
                                '<i class="fa fa-times" aria-hidden="true"></i>' +
                            '</span>' +
                            '<span>Cancelar</span>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
			'</div>' +
		'</article>' +
	'</div>' +
'</div>';

$(function () {

    /**
     * Acción al hacer click en el botón "Responder" de un comentario principal
     */    
    $('article.media.is-principal a.response').click(function (event) {
        event.preventDefault();

        $parentComment = $(event.delegateTarget).closest('div.commentary');
        $commentFooter = $parentComment.find('div.content div.level');
        
        $commentFooter.hide();
        $parentComment.append(commentTemplate);

        $parentComment.find('article.is-response button.cancel').click(function (event) {
            event.preventDefault();

            $parentComment.find('div.columns').last().remove();
            $commentFooter.show();
        });
    });

    /**
     * Acción al hacer click en el botón "Responder" de una respuesta
     */
    // $('article.media.is-principal a.response').click(function (event) {
    //     event.preventDefault();

    //     $parentComment = $(event.delegateTarget).closest('div.commentary');
    //     $commentFooter = $parentComment.find('div.content div.level');

    //     $commentFooter.hide();
    //     $parentComment.append(commentTemplate);
    // });

}); 
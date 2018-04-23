/**
 * Plantilla para responder a nuevo comentario
 */
var responseTemplate = 
'<div class="columns">' +
    '<div class="column is-11 is-offset-1">' +
        '<article class="media is-response">' +
            '<div class="media-content">' +
                '<form method="POST" action=":action:">' + 
                    '<input type="hidden" name="_token" value=":token:">' +
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
                '</form>' +
			'</div>' +
		'</article>' +
	'</div>' +
'</div>';

/**
 * Plantilla para editar comentario
 */
var updateCommentTemplate = 
'<div class="media-content">' +
    '<form method="POST" action=":action:">' +
        '<input type="hidden" name="_token" value=":token:">' +
        '<div class="field">' +
            '<p class="control">' +
                '<textarea class="textarea" name="comentario" rows="1" required>:content:</textarea>' +
            '</p>' +
        '</div>' +
        '<div class="level">' +
            '<div class="level-left"></div>' +
            '<div class="level-right">' +
                '<button type="submit" class="button is-small is-primary level-item">' +
                    '<span>Guardar</span>' +
                    '<span class="icon">' +
                        '<i class="fa fa-commenting-o" aria-hidden="true"></i>' +
                    '</span>' +
                '</button>' +
                '<button class="button is-small is-danger level-item cnl">' +
                    '<span>Cancelar</span>' +
                    '<span class="icon">' +
                        '<i class="fa fa-ban" aria-hidden="true"></i>' +
                    '</span>' +
                '</button>' +
            '</div>' +
        '</div>' +
	'</form>' +
    '<br>' +
'</div>';

$(function () {

    /**
     * Acción al hacer click en el botón "Responder" de un comentario principal
     */    
    $('article.media.is-principal a.response').click(function (event) {
        event.preventDefault();
        
        $parentComment = $(event.delegateTarget).closest('div.commentary');
        $commentFooter = $parentComment.find('div.media-content div.level');
        
        var action = $(event.delegateTarget).attr('href');
        var token = $('input[name="_token"]').eq(0).val();
        var responseForm = responseTemplate
            .replace(':action:', action)
            .replace(':token:', token);

        $commentFooter.hide();
        $parentComment.append(responseForm);

        $parentComment.find('article.is-response button.cancel').click(function (event) {
            event.preventDefault();

            $parentComment.find('div.columns').last().remove();
            $commentFooter.show();
        });
    });

    /**
     * Mostrar el textarea del comentario cuando se desea editar 
     */
    $('.media a.edt').click(function (event) {
        event.preventDefault();
        
        var action = $(event.delegateTarget).attr('href');
        var token = $('input[name="_token"]').eq(0).val();
        var content = $(event.delegateTarget)
            .closest('.media-content')
            .find('span.comment-content')
            .text();
        
        var updateComment = updateCommentTemplate
            .replace(':action:', action)
            .replace(':token:', token)
            .replace(':content:', content);
        
        var $media = $(event.delegateTarget).closest('article.media');
        var $media_content = $media.find('.media-content');
        var $updateComment = $(updateComment);
        
        $media_content.hide();
        $updateComment.appendTo($media);

        $updateComment.find('button.cnl').click(function (event) {
            event.preventDefault;
            
            $(event.delegateTarget)
                .closest('.media')
                .find('.media-content')
                .show();

            $(event.delegateTarget)
                .closest('.media-content')
                .remove();

        });
    });
}); 
/**
 * Plantilla para colocar fotos de instagram en la galería
 */
var instagramTemplate = 
'<div class="column is-4 instagram">' +
    '<div class="card-plain">' +
        '<div class="card-image">' +
            '<figure class="image is-1by1">' +
				'<a href="{{link}}" target="_blank">' +
					'<img src="{{image}}" />' +
				'</a>' +
			'</figure>' +
        '</div>' +
        '<div class="card-content insta">' +
            '<h3 class="subtitle" style="margin-botton: 5px;">' +
                '<i class="fa fa-heart-o" aria-hidden="true" style="margin-right: 5px;"></i>' +
                '<i class="fa fa-comment-o" aria-hidden="true" style="margin-right: 5px;"></i>' +
                '<i class="fa fa-paper-plane-o" aria-hidden="true" style="margin-right: 5px;"></i>' +
            '</h3>' +
            '<h6 class="subtitle is-6" style="margin: 5px 0px;">{{comments}} comentarios</h6>' +
            '<h6 class="subtitle is-6" style="margin: 5px 0px;"><strong>fundavica</strong> {{caption}}</h6>' +
        '</div>' +
    '</div>' +
'</div>';

$(function () {
    /**
     * Mostrar las fotos de instagram en la galería
     */
    var feed = new Instafeed({
        get: 'user',
        userId: '1417734543',
        accessToken: '1417734543.1677ed0.41099783a0e149919c063effcb1eec04',
        resolution: 'standard_resolution',
        template: instagramTemplate
    });
    
    feed.run();
});
import $ from 'jquery';
import Instafeed from 'instafeed.js';

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

$(function() {
    
    /**
     * Mostrar la información del usuario
     */
    var $profile_button = $('.profile-button');
    var $profile_modal = $('#profile-modal');

    $profile_button.click(function(event) {

        event.preventDefault();
        $profile_modal.toggleClass('is-active');
    });

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

    /**
     * Configuración del WYSIWYG Editor
     */
    var optg = {
        height: 400,
        toolbarButtons:
            ['bold', 'italic', 'underline', 'strikeThrough', 'paragraphFormat', '|',
                'formatOL', 'formatUL', 'quote', 'insertTable', '|', 'insertLink', 'insertImage', 'insertVideo', '-',
                'selectAll', 'clearFormatting', 'undo', 'redo'],
        imageInsertButtons: ['imageByURL'],
        videoInsertButtons: ['videoByURL'],
        paragraphFormat: {
            N: 'Normal',
            H1: 'Heading 1',
            H2: 'Heading 2',
            H3: 'Heading 3',
            H4: 'Heading 4',
        }
    };

    var re = new RegExp('(post/new|post/edit/[0-9]+)');
    
    console.log(re.test(window.location.href));

    if(re.test(window.location.href)) {
        tinymce.init({
            selector: '#tinymce',      
            height: 400,
            plugins: 'advlist autolink link image lists charmap print preview',
            setup: function (editor) {
                editor.getElement().removeAttribute('required');
            }
        });
    }
    /**
     * Eliminar las notificaciones que aparezcan en pantalla
     */
    $('button.delete').click(function(event) {
        event.preventDefault();
        $(event.target).closest('div.notification').remove();
    });

    /**
     * Mostrar el textarea del comentario cuando se desea editar 
     */
    $('.media a.edt').click(function(event) {
        event.preventDefault();

        var $comment = $(event.target).closest('article.media');
        var $textarea = $comment.next();
        
        $comment.toggle();
        $textarea.toggle();
    });

    $('.comment button.cnl').click(function(event) {
        event.preventDefault();

        var $textarea = $(event.target).closest('div.comment');
        var $comment = $textarea.prev();
        
        $comment.toggle();
        $textarea.toggle();
    });

    /**
     * Mostrar modal para preguntar si se está seguro de eliminar
     */
    $('a.del').click(function(event) {
        event.preventDefault();

        $('#delete-modal').toggleClass('is-active');
        $('#delete-button').attr('href', $(event.delegateTarget).attr('href'));
    });

    $('#delete-modal').find('.delete-button').click(function(event) {
        event.preventDefault();
        
        $('#delete-modal').toggleClass('is-active');
    });

    /**
     * Abrir opciones del dropdown
     */
    $('div.dropdown').click(function(event) {
        $(event.delegateTarget).toggleClass('is-active');
    });
});

/**
 * Para mostrar botón de hamburguesa en dispositivos moviles 
 */
document.addEventListener('DOMContentLoaded', function () {

    // Get all "navbar-burger" elements
    var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(function ($el) {
            $el.addEventListener('click', function () {

                // Get the target from the "data-target" attribute
                var target = $el.dataset.target;
                var $target = document.getElementById(target);

                // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                $el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

            });
        });
    }
});
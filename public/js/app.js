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
     * Eliminar las notificaciones que aparezcan en pantalla
     */
    $('button.delete').click(function(event) {
        event.preventDefault();
        $(event.target).closest('div.notification').remove();
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

    /**
     * Inicializar datatables
     */

    $('.tabla').DataTable({
        'language': {
            "lengthMenu": "Muestra _MENU_ filas por página",
            "zeroRecords": "No se encontraron registros",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        }
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
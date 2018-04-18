$(function () {
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

    tinymce.baseURL = window.location.origin + "/js/plugins/tinymce";
    tinymce.init({
        selector: '#tinymce',
        height: 400,
        plugins: 'advlist autolink link image lists charmap print preview',
        setup: function (editor) {
            editor.getElement().removeAttribute('required');
        }
    });
});
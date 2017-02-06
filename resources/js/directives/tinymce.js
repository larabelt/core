export default {

    inserted: function (el, binding) {

        let unique = 'editor-' + binding.value;

        $(el).addClass(unique);

        tinymce.init({
            selector: '.' + unique,
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
        });
    }
}
export default {
    inserted: function (el, binding, vnode, oldVnode) {
        let expression = vnode.data.directives.find(function(o) {
            return o.name === 'model';
        }).expression

        //@todo[lasota] Need to refactor this to not depend on 2 steps.
        expression = expression.split('.');

        tinymce.init({
            target: el,
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
            init_instance_callback: function (editor) {
                editor.on('keyup', function (e) {
                    vnode.context[expression[0]][expression[1]] = editor.getContent();
                });
                editor.on('NodeChange', function (e) {
                    vnode.context[expression[0]][expression[1]] = editor.getContent();
                });
            }
        });
    }
}
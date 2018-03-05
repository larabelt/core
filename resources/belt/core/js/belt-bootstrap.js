import Vuex from 'vuex';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
//import VueQuillEditor from 'vue-quill-editor';
import 'admin-lte';
import 'belt/core/js/adminlte/helper';
import 'bootstrap-sass';

global.Vuex = Vuex;
global.VueResource = VueResource;
global.VueRouter = VueRouter;

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

// VueQuillEditor.quillEditor.data = function() {
//     return {
//         _content: '',
//         defaultModules: {
//             toolbar: {
//                 container: [
//                     ['bold', 'italic', 'underline', 'strike'],
//                     ['blockquote', 'code-block'],
//                     [{'header': 1}, {'header': 2}],
//                     [{'list': 'ordered'}, {'list': 'bullet'}],
//                     [{'script': 'sub'}, {'script': 'super'}],
//                     [{'indent': '-1'}, {'indent': '+1'}],
//                     [{'direction': 'rtl'}],
//                     [{'size': ['small', false, 'large', 'huge']}],
//                     [{'header': [1, 2, 3, 4, 5, 6, false]}],
//                     [{'color': []}, {'background': []}],
//                     [{'align': []}],
//                     ['clean'],
//                     ['link', 'image', 'video']
//                 ],
//                 handlers: {
//                     'image': function(value) {
//                         if (value) {
//                             var href = prompt('Enter an image URL');
//                             this.quill.format('image', href);
//                         } else {
//                             this.quill.format('image', false);
//                         }
//                     }
//                 }
//             },
//         }
//     }
// };

Vue.use(Vuex);
//Vue.use(VueQuillEditor);
Vue.use(VueResource);
Vue.use(VueRouter);
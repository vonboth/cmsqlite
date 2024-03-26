import {createApp} from 'vue';
import PageStatistics from './components/start/PageStatistics.vue';
import LastUsers from './components/start/LastUsers.vue';
import TopArticles from './components/start/TopArticles.vue';
import Settings from './settings/Settings.vue';
import Menus from './menus/Menus.vue';
import moment from 'moment';
import MenuList from './components/menus/MenuList.vue';
import axios from 'axios';
import Editor from '@/components/articles/Editor.vue';
import 'sweetalert2/dist/sweetalert2.min.css';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.headers.post['Accept'] = 'application/json';
axios.defaults.headers.get['Accept'] = 'application/json';

const App = {
    data() {
        return {
            fileFormAction: '/admin/media/remove-file'
        };
    },
    // computed values
    computed: {},
    // mounted hook
    mounted() {
        // M ist glob. Objekt f. Materialize-Bibl.
        M.Sidenav.init(document.querySelectorAll('.sidenav'));
        M.FormSelect.init(
            document.querySelectorAll('select:not(.no-material)'));
        M.Datepicker.init(document.querySelectorAll('input.datepicker'));
        M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
            constrainWidth: false
        });
        M.Collapsible.init(document.querySelectorAll('.collapsible.simple'));
        M.Collapsible.init(document.querySelectorAll('.collapsible.admin-menu'),
            {
                accordion: false
            });
        M.Tabs.init(document.querySelectorAll('.tabs'));
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        M.FloatingActionButton.init(
            document.querySelectorAll('.action-btn-menu'));
        M.FloatingActionButton.init(
            document.querySelectorAll('.fixed-action-btn'));
    },
    methods: {
        // general dialog when deleting an item
        onDeleteItem(controller, id) {
            Swal.fire({
                icon: 'warning',
                title: translations.delete_item,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            })
                .then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/${controller}/delete/${id}`;
                    }
                });
        },

        // Media section: delete media file
        onDeleteMedia(filename) {
            this.fileFormAction = '/admin/media/remove-file';

            Swal.fire({
                icon: 'warning',
                title: translations.delete_item,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.remove_file.value = filename;
                    this.$refs.file_form.submit();
                } else {
                    this.$refs.remove_file.value = '';
                }
            });
        },

        // Media section: remove a directory
        onDeleteDirectory(dirname) {
            this.fileFormAction = '/admin/media/remove-dir';
            Swal.fire({
                icon: 'warning',
                title: translations.delete_directory,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.remove_dir.value = dirname;
                    this.$refs.file_form.submit();
                } else {
                    this.$refs.remove_dir.value = '';
                }
            });
        }
    }
};

const app = createApp(App);
app.provide('translations', translations);
app.provide('moment', moment);
app.component('page-statistics', PageStatistics);
app.component('last-users', LastUsers);
app.component('top-articles', TopArticles);
app.component('settings', Settings);
app.component('menus', Menus);
app.component('menu-list', MenuList);
app.component('editor', Editor);
app.mount('#main');

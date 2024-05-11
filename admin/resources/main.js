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
import Swal from 'sweetalert2';
import FileBrowser from '@/components/media/FileBrowser.vue';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.headers.post['Accept'] = 'application/json';
axios.defaults.headers.get['Accept'] = 'application/json';
window.Swal = Swal;

const App = {
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
        M.Modal.init(document.querySelectorAll('.modal'));
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
app.component('file-browser', FileBrowser);
app.directive('click-outside', {
    beforeMount(el, binding, vnode, prevVnode) {
        el.clickOutsideEvent = (event) => {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value(event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    beforeUnmount(el, binding, vnode, prevVnode) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    },
});
app.mount('#main');

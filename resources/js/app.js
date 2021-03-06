
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('priority-component', require('./components/Priority.vue'));
Vue.component('status-component', require('./components/TaskStatus.vue'));
Vue.component('global-status-component', require('./components/GlobalTaskStatus.vue'));
Vue.component('task-due', require('./components/TaskDueDate.vue'));
Vue.component('user-avatar', require('./components/UserAvatar.vue'));
Vue.component('calendar', require('./components/Calendar.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Datepicker from 'vuejs-datepicker';
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';

Vue.use(VCalendar, {
});

const app = new Vue({
    el: '#app',
    components:{
        Datepicker,
    }, 
    data:{
        mode: 'single',
        selectedDate: null,
    }
});

CKEDITOR.replace('article-ckeditor');

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../../node_modules/@cmyee/pushy/js/pushy.min');


window.Vue = require('vue');
window.Event = new Vue();
Vue.prototype.$eventHub = new Vue();
Vue.prototype.$route = require('./route');

import vuetify from '../../src/plugins/vuetify'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('editor', require('../../node_modules/@tinymce/tinymce-vue').default);
Vue.component('staff-dashboard', require('./pages/roles/staff/dashboard/staff-dashboard').default);
Vue.component('create-project', require('./pages/roles/staff/project/create/create-project.vue').default);
Vue.component('task-list', require('./components/list/task-list.vue').default);
Vue.component('task-list-item', require('./components/list/task-list-item.vue').default);
Vue.component('staff-project', require('./pages/roles/staff/project/single/single.vue').default);
Vue.component('project-list', require('./pages/roles/staff/project/list.vue').default);
Vue.component('project-summary', require('./components/project-summary.vue').default);
Vue.component('tabs', require('./components/tabs.vue').default);
Vue.component('tab', require('./components/tab.vue').default);
Vue.component('list', require('./components/list/list.vue').default);
Vue.component('pill-button', require('./components/pill-button.vue').default);
Vue.component('client-list', require('./pages/roles/staff/client/list.vue').default);
Vue.component('client-edit', require('./pages/roles/staff/client/edit/edit.vue').default);
Vue.component('create-client', require('./pages/roles/staff/client/create/create-client.vue').default);
Vue.component('pagination', require('./components/pagination.vue').default);
Vue.component('counter', require('./components/counter.vue').default);
Vue.component('events-list', require('./pages/roles/staff/event/list.vue').default);
Vue.component('users-list', require('./pages/roles/staff/user/list.vue').default);
Vue.component('user-edit', require('./pages/roles/staff/user/edit/edit.vue').default);
Vue.component('create-user', require('./pages/roles/staff/user/create/create-user.vue').default);
Vue.component('user-avatar', require('./components/user-avatar.vue').default);
Vue.component('file-manager', require('./components/file-manager.vue').default);
Vue.component('file-validator', require('./components/file-validator.vue').default);

Vue.component('client-projects-list', require('./pages/roles/client/project/list.vue').default);
Vue.component('client-project', require('./pages/roles/client/project/single/single.vue').default);

// You can also pass in the default options

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify,
    el: '#app'
}).$mount('#app');

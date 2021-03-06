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

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('members-component', require('./components/MembersDatatableComponent.vue').default);

Vue.component('reservations-component', require('./components/ReservationsDatatableComponent.vue').default);


Vue.component('my-profile', require('./components/MyProfileComponent.vue').default);

Vue.component('calendar', require('./components/CalendarComponent.vue').default);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('equipments', require('./components/Equipments.vue').default);

Vue.component('food-supplements', require('./components/FoodSupplements.vue').default);

Vue.component('bmi-component', require('./components/BMIComponent.vue').default);

Vue.component('bmi-chart', require('./components/BMIChartComponent.vue').default);

Vue.component('date-time', require('./components/dateTime.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.use(require('vue-moment'));

const app = new Vue({
    el: '#app',
});

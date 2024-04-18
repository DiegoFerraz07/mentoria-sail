/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import filters from './filters/filters';
import { ZiggyVue } from 'ziggy-js';
import PrimeVue from 'primevue/config';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.config.globalProperties.$filters = filters;

import PaginationVue from './components/Pagination.vue';
import 'primevue/resources/themes/aura-light-green/theme.css';

import Brand from './pages/brand/index.vue';
import FormBrand from './pages/brand/form.vue';
import Client from './pages/clientes/index.vue';
import FormClient from './pages/clientes/form.vue';
import Supplies from './pages/supply/index.vue';
import Product from './pages/product/index.vue';
import FormProduct from './pages/product/form.vue';
import Types from './pages/types/index.vue';
import NavNotification from './components/NavNotification.vue';

app.component('brand', Brand);
app.component('form-brand', FormBrand);
app.component('types', Types);
app.component('client', Client);
app.component('form-client', FormClient);
app.component('supplies', Supplies);
app.component('product', Product);
app.component('form-product', FormProduct);
app.component('pagination-vue', PaginationVue);
app.component('nav-notification', NavNotification);
app.use(PrimeVue);

app.use(ZiggyVue, Ziggy);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

import './bootstrap';
import '../css/app.css';

import '../css/app.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import store from './store'


createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const vueApp = createApp({ 
            render: () => h(app, props) 
        });

        vueApp.use(plugin);
        vueApp.mount(el);
        

    },
});
moment.locale('pt-br');
store.dispatch('userStateAction');




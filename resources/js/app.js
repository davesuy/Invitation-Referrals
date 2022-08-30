require('./bootstrap');

import{ createApp } from 'vue'

import TagInput from './components/TagInput.vue';

const app = createApp({});

app.component('taginput', TagInput);

app.mount('#app');

let Vue = require('vue');

Vue.component('resizer', require('./resizer.vue').default);

new Vue({
  el: '#app',
});
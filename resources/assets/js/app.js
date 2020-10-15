
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events=new Vue();
// window.events.$on('notif',(message)=>{
//     console.log(message)
// });
window.handleError=function(error){
    if (error.response.status==422){
        window.noty({
            message:'You have Validation Errors',
            type:'danger'
        })
    }
    else{
        window.noty({
            message:'Please Refresh the Page',
            type:'danger'
        })
    }
}
window.noty=function(notification){
    window.events.$emit('notification',notification);
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('vue-noty',require('./components/Noty.vue'))
Vue.component('vue-player',require('./components/Player.vue'));
Vue.component('vue-login', require('./components/Login.vue'));
Vue.component('vue-stripe',require('./components/Stripe.vue'));
Vue.component('vue-lessons',require('./components/Lessons.vue'));
Vue.component('vue-update-card',require('./components/UpdateCard.vue'));
const app = new Vue({
    el: '#app'
});

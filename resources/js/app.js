/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
import { Form, HasError, AlertError } from "vform";
//Importing moment for Vue.js Date and Time
import moment from "moment";

//Import Gate for multi level user
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

//Register for Global pagination
Vue.component("pagination", require("laravel-vue-pagination"));

//Progressbar Vue.js
import VueProgressBar from "vue-progressbar";
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "2px"
});

//sweet Alert
import swal from "sweetalert2";
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

//Vue.js Custom event

window.Fire = new Vue();

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(VueRouter);

let routes = [
    { path: "/event/:id", component: require("./components/Event.vue") },
    { path: "/", component: require("./components/Home.vue") },
    { path: "/schedule", component: require("./components/Schedule.vue") },
    {
        path: "/dailyschedule",
        component: require("./components/DailySchedule.vue")
    },
    { path: "/profile/:id", component: require("./components/Profile.vue") }
];

const router = new VueRouter({
    // mode: "history",
    // base: subscribersLinks.baseUri,
    linkActiveClass: "active",
    routes // short for `routes: routes`
});

Vue.filter("upText", function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter("myDate", function(createDate) {
    return moment(createDate).format("MMMM Do YYYY");
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue")
);

//passport client Component start here
Vue.component("passport-clients", require("./components/passport/Clients.vue"));

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue")
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue")
);
Vue.component("not-found", require("./components/NotFound.vue"));
//passport client Component End here

const app = new Vue({
    router,
    el: "#app",
    data: {
        search: ""
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit("searching");
        }, 1000)
    }
});

Vue.filter("EventYear", function(eventStartDate) {
    return moment(eventStartDate).format("YYYY");
});
Vue.filter("EventMonth", function(eventStartDate) {
    return moment(eventStartDate).format("MMMM");
});
Vue.filter("EventDate", function(eventStartDate) {
    return moment(eventStartDate).format("Do");
});

Vue.filter("EventTime", function(eventStartTime) {
    var time = eventStartTime.split(":");
    return time[0] > 12
        ? time[0] - 12 + " : " + time[1] + " PM"
        : time[0] + ":" + time[1] + " Am";
});
Vue.filter("empty", function(data) {
    return data == null || data == "" ? "not inputed" : data;
});

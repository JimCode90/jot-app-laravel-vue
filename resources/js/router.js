import  Vue from 'vue';
import VueRouter from 'vue-router'
import ExampleComponent from "./components/ExampleComponent";
import ContactsCreate from "./views/ContactsCreate";
import ContactsShow from "./views/ContactsShow";

Vue.use(VueRouter)

export default new VueRouter({
    routes:[
        {
            path: '/', component: ExampleComponent,
            meta: { title: 'Welcome' }
        }, {
            path: '/contacts', component: ExampleComponent,
            meta: { title: 'Contacts' }
        }, {
            path: '/contacts/create', component: ContactsCreate,
            meta: { title: 'Add New Contact' }
        }, {
            path: '/contacts/:id', component: ContactsShow,
            meta: { title: 'Details for Contact' }
        }, {
            path: '/contacts/:id/edit', component: ExampleComponent,
            meta: { title: 'Edit Contact' }
        }, {
            path: '/birthdays', component: ExampleComponent,
            meta: { title: 'This Month\'s Birthdays' }
        }, {
            path: '/logout', component: ExampleComponent
        }
    ],
    mode: 'history'
})

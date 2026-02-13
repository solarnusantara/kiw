import VueNumberInput from "@chenfengyuan/vue-number-input";
import { createApp } from "vue";
import VueSocialSharing from "vue-social-sharing";
import VueTelInput from "vue-tel-input";
import { VueHeadMixin, createHead } from '@unhead/vue'

import "vue-tel-input/vue-tel-input.css";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "../sass/app.scss";
import "./bootstrap.js";

import { i18n } from "./plugins/i18n.js";
import init from "./plugins/init.js";
import plugins from "./plugins/plugins.js";
import router from "./router/router.js";
import store from "./store/store.js";
import Mixin from "./utils/mixin.js";

import TheShop from "./components/TheShop.vue";
import Banner from "./components/inc/Banner.vue";
import DynamicLink from "./components/inc/DynamicLink.vue";
import ProductBox from "./components/product/ProductBox.vue";
import HelperClass from "./utils/helpers.js";

import { install } from "vue3-recaptcha-v2";
// import {createMetaManager} from "vue-meta";




const shopSetting = window.shopSetting;

const app = createApp(TheShop);

// color override
const customDarkTheme = {
    colors: {
        primary: shopSetting.primaryColor,
    },
};

let shopSelectedLanguage = localStorage.getItem("shopSelectedLanguage");
const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "customDarkTheme",
        themes: {
            customDarkTheme,
        },
    },
    locale: {
        locale:  shopSelectedLanguage ?? "en",
        fallback:  shopSelectedLanguage ?? "en",
      },
});
const globalOptions = {
    mode: "auto",
};

app.component("dynamic-link", DynamicLink);
app.component("banner", Banner);
app.component("product-box", ProductBox);
app.component("vue-number-input", VueNumberInput);

init(store, router);
const head = createHead()
app.mixin(VueHeadMixin)
// app.use(createMetaManager());
app.use(head);
app.use(vuetify);
app.use(VueSocialSharing);
app.use(VueTelInput, globalOptions);
app.use(store);
app.use(router);
app.use(i18n);
app.use(install, {
    sitekey: import.meta.env.VITE_RECAPTCHA_SITE_KEY,
    cnDomains: false,
})

app.mixin(Mixin);
app.use(init);
app.use(plugins);
app.provide(HelperClass);
app.mount("#app");

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/serviceworker.js').then(function (registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}

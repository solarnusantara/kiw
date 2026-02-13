<template>

  <div>
    <v-app class="d-flex flex-column app">
      <v-locale-provider   isRTL >

      <Header />

      <v-main class="aiz-main-wrap">
        <router-view :key="['ShopDetails','ShopCoupons','ShopProducts'].includes($route.name) ? null : $route.path"
         @loaded="onRouterViewLoaded"
         ></router-view>
         <Footer v-if="routerViewLoadedState" :class="['footer mt-auto']" />
      </v-main>
      <v-locale-provider   isRTL >
      <BottomChat />
      </v-locale-provider>

      <div :class="['sidebar-cart-placeholder', { 'd-none': !sidebarCartLoading }]"></div>
      <SidebarCart @loaded="sidebarCartLoaded" />
      <div :class="['add-to-cart-dialog-placeholder', { 'd-none': !addToCartDialogLoading }]"></div>
      <AddToCartDialog @loaded="addToCartDialogLoaded" />
      <div v-if="!isAuthenticated" :class="['login-dialog-placeholder', { 'd-none': !loginDialogLoading }]"></div>
      <LoginDialog v-if="!isAuthenticated" @loaded="loginDialogLoaded" />
      <div :class="['mobile-menu-placeholder', { 'd-none': !mobileMenuLoading }]"></div>
      <MobileMenu class="d-lg-none user-side-nav" @loaded="mobileMenuLoaded" />
      <div :class="['whatsapp-placeholder', { 'd-none': !whatsappLoading }]"></div>
      <Whatsapp :data="whatsappData" @loaded="whatsappLoaded" />
      <div :class="['snackbar-placeholder', { 'd-none': !snackBarLoading }]"></div>
      <SnackBar @loaded="snackBarLoaded" />

    </v-locale-provider>
    </v-app>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";



import Header from "./header/Header.vue";
import Footer from "./footer/Footer.vue";
import LoginDialog from "./auth/LoginDialog.vue";
import SidebarCart from "./cart/SidebarCart.vue";
import BottomChat from "./inc/BottomChat.vue";
import MobileMenu from "./inc/MobileMenu.vue";
import SnackBar from "./inc/SnackBar.vue";
import Whatsapp from "./inc/Whatsapp.vue";
import AddToCartDialog from "./product/AddToCartDialog.vue";
import { useHead } from '@unhead/vue'
import { defineAsyncComponent } from 'vue';

// const Footer = defineAsyncComponent(() => import('./footer/Footer.vue'));
// const BottomChat = defineAsyncComponent(() => import('./inc/BottomChat.vue'));
// const SidebarCart = defineAsyncComponent(() => import('./cart/SidebarCart.vue'));
// const AddToCartDialog = defineAsyncComponent(() => import('./product/AddToCartDialog.vue'));
// const LoginDialog = defineAsyncComponent(() => import('./auth/LoginDialog.vue'));
// const MobileMenu = defineAsyncComponent(() => import('./inc/MobileMenu.vue'));
// const SnackBar = defineAsyncComponent(() => import('./inc/SnackBar.vue'));
// const Whatsapp = defineAsyncComponent(() => import('./inc/Whatsapp.vue'));

export default {

  components: {
    Header,
    Footer,
    BottomChat,
    SidebarCart,
    SnackBar,
    LoginDialog,
    MobileMenu,
    AddToCartDialog,
    Whatsapp
  },
  data: () => ({
    isRTL: ' ',
    metaTitle: '',
    metaDescription: '',
    metaScript: {},
    footerLoading: true,
    bottomChatLoading: true,
    sidebarCartLoading: true,
    addToCartDialogLoading: true,
    loginDialogLoading: true,
    mobileMenuLoading: true,
    snackBarLoading: true,
    whatsappLoading: true,
    whatsappData: {},
    allComponentsLoaded: false,
    routerViewLoadedState: false,

    // isAuthenticated: false
  }),

  computed: {
    ...mapGetters("auth", ["isAuthenticated"]),
    ...mapGetters("cart", ["getTempUserId"]),
    ...mapGetters("app", ["appMetaTitle", "appMetaDescription","userLanguageObj", "routerLoading"]),
  },
  watch: {
        metaTitle(newTitle) {
        this.updateHead(newTitle, this.metaDescription);
        },
        metaDescription(newDescription) {
        this.updateHead(this.metaTitle, newDescription);
        },
        metaScript(newScript) {
        this.updateHead(this.metaTitle, this.metaDescription, newScript);
        },

    },
  methods: {
    ...mapActions("auth", ["getUser", "checkSocialLoginStatus"]),
    ...mapActions("cart", ["fetchCartProducts"]),
    ...mapMutations("auth", ["setSociaLoginStatus"]),
    changeRTL() {
      if (this.userLanguageObj.rtl == 1) {
        this.isRTL = "rtl"
        this.$vuetify.rtl = true;
      } else {
        this.isRTL = " "
        this.$vuetify.rtl = false;
      }
    },
    async getTempCartData() {
      if (this.isAuthenticated && this.getTempUserId) {
        const res = await this.call_api("post", "temp-id-cart-update", {
          temp_user_id: this.getTempUserId,
        });
        this.fetchCartProducts();
      }
    },
    async updateHead() {
            useHead({
                title: this.metaTitle,
                meta: [
                { name: 'description', content: this.metaDescription },
                { name: 'keywords', content: this.metaDescription },
                { property: 'og:title', content: this.metaTitle },
                { property: 'og:description', content: this.metaDescription },
                { property: 'og:type', content: 'article' },
                { property: 'og:url', content: window.location.href },
                { property: 'og:image', content: this.metaImage },
                { name: 'twitter:card', content: 'summary_large_image' },
                { name: 'twitter:title', content: this.metaTitle },
                { name: 'twitter:description', content: this.metaDescription },
                { name: 'twitter:image', content: this.metaImage },
                ]
            });
        },
    updateWhatsappData(data) {
      this.whatsappData = data; // Update the data for Whatsapp component
    },
    bottomChatLoaded() {
      this.bottomChatLoading = false;
    },
    sidebarCartLoaded() {
      this.sidebarCartLoading = false;
    },
    addToCartDialogLoaded() {
      this.addToCartDialogLoading = false;
    },
    loginDialogLoaded() {
      this.loginDialogLoading = false;
    },
    mobileMenuLoaded() {
      this.mobileMenuLoading = false;
    },
    snackBarLoaded() {
      this.snackBarLoading = false;
      this.checkAllComponentsLoaded();
    },
    whatsappLoaded() {
      this.whatsappLoading = false;
    },
    onRouterViewLoaded() {
      this.routerViewLoadedState = true;
    },
    checkAllComponentsLoaded() {
      if (
        // !this.sidebarCartLoading &&
        // !this.addToCartDialogLoading &&
        // !this.loginDialogLoading &&
        // !this.mobileMenuLoading &&
        // !this.whatsappLoading &&
        !this.snackBarLoading
      ) {
        this.allComponentsLoaded = true;
      }
    },
  },
  async created() {
    this.changeRTL();
    await this.getUser();
    setTimeout(() => {
      this.checkSocialLoginStatus();
      this.getTempCartData();
    }, 200);

    this.metaTitle = this.appMetaTitle;
    this.metaDescription = this.appMetaDescription;
    this.metaScript = {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": this.appMetaTitle,
        "url": window.location.href,
        "potentialAction": {
          "@type": "SearchAction",
          "target": `${window.location.origin}/search/{search_term_string}`,
          "query-input": "required name=search_term_string"
        }
    };
    // this.updateHead();
  },

};
</script>

<style scoped>
.app{overflow-x: hidden;}
.absolute-full {
    background: #fff;
    z-index: 10000;
}
.footer-placeholder {
  height: 200px; /* Adjust this value based on the expected height of the footer */
  background-color: #f0f0f0; /* Optional: Add a background color to match the footer */
}
.bottom-chat-placeholder,
.sidebar-cart-placeholder,
.add-to-cart-dialog-placeholder,
.login-dialog-placeholder,
.mobile-menu-placeholder,
.whatsapp-placeholder,
.snackbar-placeholder {
  height: 50px; /* Adjust this value based on the expected height of the component */
  background-color: #f0f0f0; /* Optional: Add a background color to match the component */
}
.footer {
  height: 100px; /* Fixed height to avoid layout shifts */
  background-color: #f8f9fa; /* Background color */
  display: flex;
  align-items: center;
  justify-content: center;
  /* Other styling as needed */
}
</style>

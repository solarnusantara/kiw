<template>
<footer class="footer mt-auto bg-grey-darken-4 pt-8 text-white pb-md-10 pb-lg-0 mb-15 mb-lg-0">
    <v-container class="main-footer">
        <v-row>
            <v-col cols="12" sm="8" md="6" lg="3">
            <FooterLogo :isLoading="loading" :logo="logo"/>
                <!-- <div class="primary-text fs-14 fw-700 mb-7">
                    {{ $t("get_your_special_offers_coupons__more") }}
                </div>
                <v-form v-on:submit.prevent="subscribe()">
                    <div class="relative mb-5">
                            <v-text-field
                                :placeholder="$t('your_email_address')"
                                type="email"
                                color="primary"
                                class="bg-white mb-2  text-field"
                                v-model="subscribeForm.email"
                                hide-details="auto"
                                required
                                variant="plain"
                            ></v-text-field>
                            <p v-for="error of v$.subscribeForm.email.$errors" :key="error.$uid" class="text-red absolute">
                                {{ error.$message }}
                            </p>
                    </div>
                    <v-btn
                        v-bind="{
                            variant: 'outlined',
                            class: 'px-12 mb-4',
                            elevation: 0,
                            type: 'submit',
                            color: 'primary',
                            loading: subscribeFormLoading,
                            disabled: subscribeFormLoading,
                            outlined: true
                        }"
                        @click="subscribe"
                    >{{ $t("subscribe") }}</v-btn>
                </v-form> -->
                <div class="">
                    <ul class=" list-unstyled d-flex list-unstyled ps-0 fs-13">
                        <li
                            v-for="(link, label, i) in social_link"
                            :key="i"
                            :class="['social-icon', { 'ms-2': i != 0 }]"
                            class="mb-4"
                        >
                            <a
                                :href="link"
                                :class="label"
                                target="_blank"
                            >
                                <i :class="{ lab: true, ['la-' + label]: true, }"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </v-col>

            <FooterLinks :links="footer_link_one" offset-lg="1" />
            <FooterLinks :links="footer_link_two" />
            <FooterContact :contact="contact" />
            <FooterMobileApps :mobileAppLinks="mobileAppLinks" :appStore="app_store" :playStore="play_store" />
        </v-row>
        <div class="py-3 border-top border-bottom border-gray-800">
            <ul class="list-unstyled d-flex flex-wrap ps-0">
                <li
                    v-for="(link, label, i) in data.footer_menu"
                    :key="i"
                    :class="[ 'py-2 pe-4 pe-md-7', { 'ps-md-3 ps-md-7': i !== 0 }]"
                >
                    <dynamic-link
                        :to="link"
                        append-class="text-reset"
                    >{{ label }}</dynamic-link>
                </li>
            </ul>
        </div>
        <v-row class="">
            <v-col
                md="6"
                cols="12"
                :version="data.current_version"
            >
                <div
                    v-html="data.copyright_text"
                    class="lh-4 fs-13"
                ></div>
            </v-col>

        </v-row>
    </v-container>
</footer>

  <!-- cookie dialog box -->
  <template  v-if="this.getCookieDescription">
  <div class="text-center pa-4 cookie">
    <v-btn @click="showCookie = true">
      Open Dialog
    </v-btn>

    <v-dialog
      v-model="showCookie"
      width="auto"
      class="cookie text-center"
    >
      <v-card
        max-width="400"
        prepend-icon="mdi-update"
        :text="this.getCookieDescription"
        :title=" this.getCookieTitle"
      >
        <template v-slot:actions>
          <v-btn
            class="text-none ms-auto text-white btn-primary"
            rounded="0"
            variant="flat"
            @click="setCookie(true)"
          >
            Accept Cookies
          </v-btn>
        </template>
      </v-card>
    </v-dialog>
  </div>
</template>
  <!--  -->
</template>

<script>
// import { useVuelidate } from "@vuelidate/core";
// import { email, required } from "@vuelidate/validators";
import { mapActions, mapGetters } from "vuex";
import FooterContact from "./FooterContact.vue";
import FooterLinks from './FooterLinks.vue';
import FooterLogo from './FooterLogo.vue';
import FooterMobileApps from './FooterMobileApps.vue';
export default {
  emits: ['loaded'],
    components: {
        FooterLogo,
        FooterLinks,
        FooterContact,
        FooterMobileApps,
  },
  data: () => ({
    loading: true,
    isLoading: true,
    data: {},
    // v$: useVuelidate(),
    // subscribeForm: {
    //   email: "",
    // },
    // subscribeFormLoading: false,
    app_store: null,
    play_store: null,
    showCookie: false,
    dialog: true,
    logo: "",
    contact: {
      email: "",
      phone: "",
      address: "",
    },
    mobileAppLinks: {
      app_store: null,
      play_store: null,
    },
    social_link: [],
    footer_link_one: [],
    footer_link_two: [],
  }),

//   validations() {
//     return {
//       subscribeForm: {
//         email: {
//           required,
//           email,
//         },
//       },
//     };
//   },
  mounted() {
    this.getDetails();
    this.$emit('loaded');
  },
  computed: {
    ...mapGetters("app", ["appName","appUrl","generalSettings","getCookieStatus","getCookieTitle","getCookieDescription"]),
    ...mapGetters("auth", ["isAuthenticated"]),
    // ...mapGetters("affiliate", ["isAffiliatedUser"]),
  },

  methods: {
    ...mapActions("affiliate", ["fetchAffiliatedUser"]),
    ...mapActions("app", ["setCookie"]),
    async setCookie(status) {

      document.cookie = this.appName +'-cookie' + "=" + this.getCookieDescription;
      localStorage.setItem("cookieStatus", status);
      this.showCookie = false;
    },

    async getDetails() {
      const res = await this.call_api("get", `setting/footer`);
      if (res.status === 200) {
        this.data = res.data;
        // console.log(this.data);
        this.app_store = res.data.mobile_app_links.app_store;
        this.play_store = res.data.mobile_app_links.play_store;
        this.contact = res.data.contact_info;
        this.social_link = res.data.social_link;
        // console.log(this.social_link);
        this.footer_link_one = res.data.footer_link_one;
        this.footer_link_two = res.data.footer_link_two;
        this.mobileAppLinks= {
            app_store: res.data.mobile_app_links.app_store,
            play_store: res.data.mobile_app_links.play_store,
        },
        this.logo= res.data.footer_logo,
        this.loading = false;
        // this.$emit('data-updated', this.data);
      }
    },

    // async subscribe() {
    //   const isFormCorrect = await this.v$.$validate();
    //   if (!isFormCorrect) return;

    //   this.subscribeFormLoading = true;
    //   const res = await this.call_api("post", "subscribe", this.subscribeForm);
    //   this.snack({ message: res.data.message });
    //   this.subscribeFormLoading = false;
    // },
  },


  created() {
    if (this.getCookieStatus == null) {
      this.showCookie = true;
    }
    this.getDetails();
    // if (this.isAuthenticated) {
    //   this.fetchAffiliatedUser();
    // }
  },
};
</script>

<style scoped>
.absolute-full {
  background: #fff;
  z-index: 10000;
}
.img-fluid {
  display: block;
  width: 145px;
  height: auto;
  margin-right: 20px;
  min-height: 50px; /* Reserve space for the image */
}
.relative {
  position: relative;
}
.absolute {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  color: red;
}
</style>

<template>
  <v-col
          class="mb-5  d-lg-block"
          lg="2"
          cols="12"
        >
          <div
            class="mobile-apps-area"
            v-if="appStore || playStore"
          >
            <h4 class="primary mb-4">{{ $t("mobile_apps") }}</h4>
            <a
              v-if="playStore"
              :href="mobileAppLinks?.play_store"
              target="_blank"
              class="d-inline-block pt-2 mr-2"
            >
              <img
                :src="static_asset('/assets/img/play_store.webp')"
                class="mw-100"
                height="40"
                width="135"
              />
            </a>
            <a
              v-if="appStore"
              :href="mobileAppLinks?.app_store"
              target="_blank"
              class="d-inline-block pt-2 mr-2"
            >
              <img
                :src="static_asset('/assets/img/app_store.webp')"
                class="mw-100"
                width="135"
                height="40"
              />
            </a>
          </div>

        </v-col>
</template>

<script>
export default {
  props: {
    mobileAppLinks: {
      type: Object,
      required: true
    },
    appStore: {
      type: String,
      default: '#',
    },
    playStore: {
      type: String,
      default: '#',
    }
  },
  methods: {
    staticAsset(path) {
      return require(`${path}`);
    }
  }
}
</script>

<style scoped>
    .primary-text {
    color: #ffffff; /* Adjust color as needed */
    }
</style>

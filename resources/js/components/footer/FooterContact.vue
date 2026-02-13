<template>
<v-col
          class="mb-5  d-lg-block"
          lg="2"
          cols="12"
        >
          <h4 class="primary mb-4">{{ $t("contact_us") }}</h4>
          <ul class="list-unstyled ps-0 fs-13">
            <li class="py-2 mb-2">
              <div class="opacity-50">
                <i class="las la-home me-3 mb-2"></i>
                {{ $t("address") }}
              </div>
              <div>
                <div style="white-space: pre-wrap;">{{ contact?.contact_address }}</div>
              </div>
            </li>
            <li class="py-2 mb-2">
              <div class="opacity-50">
                <i class="las la-envelope me-3 mb-2"></i>
                {{ $t("email") }}
              </div>
              <div>
                {{ contact?.contact_email }}
              </div>
            </li>
            <li class="py-2 mb-2">
              <div class="opacity-50">
                <i class="las la-phone me-3 mb-2"></i>
                {{ $t("phone") }}
              </div>
              <div>
                {{ contact?.contact_phone}}
              </div>
            </li>
          </ul>
        </v-col>
</template>

<script>
export default {
  props: {
    contact: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>
.primary-text {
  color: #ffffff; /* Adjust as needed */
}
</style>

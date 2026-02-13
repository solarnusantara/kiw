<template>
  <div class="footer-logo border-bottom pb-7 border-gray-800 mb-6">
      <div  v-if="isLoading" class="skeleton-loader" style="width: 145px; height: auto; margin-right: 20px;">
          <svg width="145" height="auto" viewBox="0 0 145 20" xmlns="http://www.w3.org/2000/svg" fill="#ccc">
              <rect width="100%" height="100%" />
            </svg>
        </div>
        <img
          v-else
          :src="logo"
          :srcset="logo"
          sizes="(max-width: 600px) 145px, (max-width: 1200px) 290px, 435px"
          alt="footer logo"
          class="img-fluid"
          width="145"
          height="auto"
          style="width: 145px; height: auto; margin-right: 20px;"
        />
    </div>
</template>

<script>
export default {
  props: {
    logo: {
      type: String,
      required: true
    },
    isLoading: {
      type: Boolean,
      default: true
    }
    // logoSrcSet: {
    //   type: String,
    //   required: true
    // }
  }
}
</script>

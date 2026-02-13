<template>
    <v-col class="mb-5 d-lg-block" lg="2" sm="6" md="3">
        <h4 class="primary mb-4"> {{ links?.title }} </h4>
        <ul class="list-unstyled ps-0 fs-13">
        <li
            v-for="(link, label, i) in links?.menu"
            :key="i"
            class="py-2"
        >
            <dynamic-link
            :to="link"
            append-class="text-reset"
            >{{ label }}</dynamic-link>
        </li>
        </ul>
    </v-col>
</template>

<script>
export default {
  props: {
    links: {
      type: Object,
      required: true,
    },

  }
}
</script>

<style scoped>
.primary-text {
  color: #ffffff; /* Adjust color as needed */
}
</style>

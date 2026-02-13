<template>
    <div class="banner">
        <template v-if="loading">
            <v-skeleton-loader type="image" :height="height"  class="skeleton-loader"></v-skeleton-loader>
        </template>
        <template v-else>
            <dynamic-link
                :to="banner.link ? banner.link : '/'"
                append-class="text-reset d-block lh-0"
            >
                <img :src="banner.img"
                class="img-fluid w-100"
                :height="height"
                width="auto"
                :alt="appName"
                @load="onImageLoad"
                />
            </dynamic-link>
        </template>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: {
        loading: { type: Boolean, required: true, default: true },
        banner: {
            type: Object,
            required: true,
        },
        height: {
            type: Number,
            default: 145,
        },
    },
    data() {
    return {
        imageLoaded: false,
        isLoading: this.loading,
        };
    },
    methods: {
        onImageLoad() {
        this.imageLoaded = true;
        this.$emit('loaded');
        },
    },
    watch: {
        imageLoaded(newValue) {
        if (newValue) {
            this.isLoading = false;
        }
        },
    },
    computed: {
        ...mapGetters("app", ["appName"]),
    },
};
</script>

<style scoped>
.img-fluid {
  display: block;
  max-width: 100%;
  height: auto;
}
.banner {
  position: relative;
  width: 100%;
}

.skeleton-loader {
  width: 100%;
  background-color: #e0e0e0;
}

/* Responsive styles */
@media (max-width: 1200px) {
  .skeleton-loader {
    min-height: 350px;
  }
}

@media (max-width: 992px) {
  .skeleton-loader {
    min-height: 400px;
  }
}

@media (max-width: 768px) {
  .skeleton-loader {
    min-height: 450px;
  }
}

@media (max-width: 576px) {
  .skeleton-loader {
    min-height: 500px;
  }
}
</style>

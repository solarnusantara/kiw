<template>
    <div v-if=loading>
        <v-skeleton-loader
            type="image"
            class="img-fluid category-container "
            height="150"
        ></v-skeleton-loader>
    </div>
  <div  v-else class="category-container" >
    <v-container  class="py-0 pe-0 pe-md-3 ps-3" >
      <div class="d-flex justify-space-between align-center mb-4 pe-3 pe-md-0">
        <!-- <h2 class="">{{ $t('popular_categories') }}</h2> -->
        <router-link
          :to="{ name: 'AllCategories' }"
          class="py-2 primary-text lh-1 d-inline-block ms-auto"
        >
          {{ $t('view_all') }}
          <i class="las la-angle-right"></i>
        </router-link>
      </div>

        <swiper
        :slides-per-view="carouselOption.slidesPerView"
        :space-between="carouselOption.spaceBetween"
        :autoplay="carouselOption.autoplay"
        :modules="modules"
        :breakpoints="carouselOption.breakpoints"
        :loop=carouselOption.loop
        :navigation="{
            nextEl: '.arrow-left',
            prevEl: '.arrow-right'
            }"
        >
        <div class="arrow-left arrow  d-none d-md-block" style="width: 30px; height: 30px; right: 10px; top: 50%; transform: translateY(-50%);">
            <svg viewBox="64 64 896 896" focusable="false" data-icon="double-right" width="1em" height="1em" fill="currentColor" aria-hidden="true">
            <path d="M533.2 492.3L277.9 166.1c-3-3.9-7.7-6.1-12.6-6.1H188c-6.7 0-10.4 7.7-6.3 12.9L447.1 512 181.7 851.1A7.98 7.98 0 00188 864h77.3c4.9 0 9.6-2.3 12.6-6.1l255.3-326.1c9.1-11.7 9.1-27.9 0-39.5zm304 0L581.9 166.1c-3-3.9-7.7-6.1-12.6-6.1H492c-6.7 0-10.4 7.7-6.3 12.9L751.1 512 485.7 851.1A7.98 7.98 0 00492 864h77.3c4.9 0 9.6-2.3 12.6-6.1l255.3-326.1c9.1-11.7 9.1-27.9 0-39.5z"></path>
            </svg>
        </div>
        <div class="arrow-right arrow  d-none d-md-block" style="width: 30px; height: 30px; left: 10px; top: 50%; transform: translateY(-50%);">
            <svg viewBox="64 64 896 896" focusable="false" data-icon="double-left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
            <path d="M272.9 512l265.4-339.1c4.1-5.2.4-12.9-6.3-12.9h-77.3c-4.9 0-9.6 2.3-12.6 6.1L186.8 492.3a31.99 31.99 0 000 39.5l255.3 326.1c3 3.9 7.7 6.1 12.6 6.1H532c6.7 0 10.4-7.7 6.3-12.9L272.9 512zm304 0l265.4-339.1c4.1-5.2.4-12.9-6.3-12.9h-77.3c-4.9 0-9.6 2.3-12.6 6.1L490.8 492.3a31.99 31.99 0 000 39.5l255.3 326.1c3 3.9 7.7 6.1 12.6 6.1H836c6.7 0 10.4-7.7 6.3-12.9L576.9 512z"></path>
            </svg>
        </div>

          <swiper-slide v-for="(category, i) in categories" :key="i" class="" >
            <router-link class="text-center d-block text-reset" :to="{ name: 'Category', params: {categorySlug: category.slug}}" >
              <img
                :src="category.banner"
                :alt="category.name"
                @error="imageFallback($event)"
                class="img-fluid border border-2 rounded-circle shadow"
                :class="{ 'shadow-primary': true }"

                width="55"
                height="55"
                style="width: 55px; height: 55px; object-fit: cover; object-position: center;"
              >
              <div class="fs-13 opacity-80 text-truncate d-none d-md-block mt-1">{{ category.name }}</div>
            </router-link>
          </swiper-slide>
        </swiper>
    </v-container>
  </div>
</template>

<script>
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from "swiper/vue";

export default {

  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
      return {
        modules: [Autoplay, Pagination, Navigation],
      };
    },

data: () => ({
    loading: true,
    categories: [],
    carouselOption: {
        slidesPerView: 8,
        spaceBetween: 20,
        loop: true,
        loopFillGroupWithBlank: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        loop: true,
        navigationOptions: {
            nextEl: '.arrow-left',
            prevEl: '.arrow-right',
        },
        breakpoints: {
            0: {
                slidesPerView: 4,
                spaceBetween: 12,
                loop: true,
            },
            // when window width is >= 320px
            599: {
                slidesPerView: 5,
                spaceBetween: 16,
                loop: true,
            },
            // when window width is >= 480px
            960: {
                slidesPerView: 6,
                spaceBetween: 20,
                loop: true,
            },
            // when window width is >= 640px
            1264: {
                slidesPerView: 7,
                spaceBetween: 20,
                loop: true,
            },
            1904: {
                slidesPerView: 8,
                spaceBetween: 20,
                loop: true,
                initialSlide: 1,
            },
        },
    },
}),
  async created() {
    const res = await this.call_api("get", "setting/home/popular_categories");
    if (res.data.success) {
      this.categories = res.data.data.data;
      this.loading = false;
    }
  },
};
</script>
<style scoped>
h2 {
  font-size: 16px;
}
@media (min-width: 960px) {
  h2 {
    font-size: 24px;
  }
}
.arrow {
  position: absolute;
  top: 50%;
  margin-top: -5px;
  z-index: 100;
}
 .arrow .arrow-left {
  left: 0;
}
 .arrow .arrow-right {
  right: 0;
}
.category-container {
  height: 150px;
}

@media (max-width: 600px) {
  .category-container {
    height: 120px;
  }
}
</style>

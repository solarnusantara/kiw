<template>
    <v-container class="py-0 px-0 px-md-3 mt-1 ">
        <swiper
            :options="carouselOption"
            :slides-per-view=carouselOption.slidesPerView
            :loop=carouselOption.loop
            :autoplay=carouselOption.autoplay
            :modules="modules"
         class="">
            <swiper-slide v-for="(banner, i) in banners" :key="i" class="">
                <banner :loading="loading" :height="310" :banner="banner"/>
            </swiper-slide>
        </swiper>
    </v-container>
</template>

<script>
// Import Swiper Vue.js components
import { Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from "swiper/vue";
export default {
    components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
        return {
            modules: [Autoplay],
        };
    },
    data: () => ({
        loading: true ,
        banners: [],
        carouselOption: {
            slidesPerView: 1,
            loop: true,
        },
        loopFillGroupWithBlank: true,
        autoplay: {
            delay: 1000,
            disableOnInteraction: false,
        },
    }),
    async created(){
        const res = await this.call_api("get", "setting/home/banner_section_one");
        if (res.data.success) {
            this.banners = res.data.data
            this.loading = false
        }
    }
}
</script>
<style scoped>

.banner {
  width: 100%;
  max-height: 280px; /* Default height */
}

/* Responsive styles */
@media (max-width: 1200px) {
  .banner {
    max-height: 250px;
  }
}

@media (max-width: 992px) {
  .banner {
    max-height: 200px;
  }
}

@media (max-width: 768px) {
  .banner {
    max-height: 150px;
  }
}

@media (max-width: 576px) {
  .banner {
    max-height: 100px;
  }
}
</style>

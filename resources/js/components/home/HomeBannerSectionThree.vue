<template>
    <v-container class="py-0 px-0 px-md-4 mb-4">
        <swiper :options="carouselOption"
            :slides-per-view=carouselOption.slidesPerView
            :space-between=carouselOption.spaceBetween
            :breakpoints= carouselOption.breakpoints
            :loop=carouselOption.loop
            :autoplay=carouselOption.autoplay
            :modules="modules"
          >
            <swiper-slide v-for="(banner, i) in banners" :key="i" class="">
                <banner :loading="loading"  :height="145" :banner="banner"/>
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
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            loopFillGroupWithBlank: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                // when window width is >= 320px
                599: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                // when window width is >= 480px
                960: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                // when window width is >= 640px
                1264: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                1904: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
            }
        },
    }),
    async created(){
        // const res = await this.call_api("get", "setting/home/banner_section_three");
          try {
                // Fetch banners data from API or other source
                const response = await this.call_api("get", "setting/home/banner_section_three");
                this.banners = response.data.data;
                this.loading = false;
                this.adjustCarouselOptions();
            } catch (error) {
                // // console.error('Error fetching banners:', error);
                this.loading = false;
            }
    },
    methods: {
    adjustCarouselOptions() {
      const totalSlides = this.banners.length;
      if (totalSlides < this.carouselOption.slidesPerView) {
        this.carouselOption.slidesPerView = totalSlides;
        this.carouselOption.slidesPerGroup = totalSlides;
      }
    }
  }
}
</script>

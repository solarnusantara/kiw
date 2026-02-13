<template>
  <div>

    <!-- popular categories -->
    <HomePopularCategories />

    <!-- home banner 1 -->
    <HomeBannerSectionOne />

    <!-- slider area -->
    <HomeSliders />

    <!-- product section 1 -->
    <HomeProductSectionOne />




    <!-- shop section 1 -->
    <!-- <HomeShopSectionOne v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- home shop banner 1 -->
    <!-- <HomeShopBannerSectionOne v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- product section 2 -->
    <HomeProductSectionTwo />

    <!-- home banner 2 -->
    <HomeBannerSectionTwo />

    <!-- shop section 2 -->
    <!-- <HomeShopSectionTwo v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- home shop banner 2 -->
    <!-- <HomeShopBannerSectionTwo v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- shop section 3 -->
    <!-- <HomeShopSectionThree v-if="is_addon_activated('multi_vendor')" /> -->


    <!-- home banner 3 -->
    <HomeBannerSectionThree />
    <!-- product section 3 -->
    <HomeProductSectionThree />

    <!-- shop section 4 -->
    <!-- <HomeShopSectionFour v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- product section 4 -->
    <HomeProductSectionFour />

    <!-- shop section 5 -->
    <!-- <HomeShopSectionFive v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- home shop banner 3 -->
    <!-- <HomeShopBannerSectionThree v-if="is_addon_activated('multi_vendor')" /> -->

    <!-- product section 5 -->
    <HomeProductSectionFive />

    <!-- home banner 4 -->
    <HomeBannerSectionFour />

    <!-- product section 6 -->
    <HomeProductSectionSix />

    <div class="py-8 bg-grey-lighten-4 mt-8">
      <v-container>
        <HomeAboutText />
        <HomeAllCategories />
      </v-container>
    </div>
  </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';

// import HomePopularCategories from '../components/home/HomePopularCategories.vue';

// import HomeBannerSectionOne from '../components/home/HomeBannerSectionOne.vue';

// const HomePopularCategories = defineAsyncComponent(() => import('../components/home/HomePopularCategories.vue'));
// const HomeSliders = defineAsyncComponent(() => import('../components/home/HomeSliders.vue'));
// const HomeProductSectionOne = defineAsyncComponent(() => import('../components/home/HomeProductSectionOne.vue'));
// const HomeProductSectionTwo = defineAsyncComponent(() => import('../components/home/HomeProductSectionTwo.vue'));
// const HomeProductSectionThree = defineAsyncComponent(() => import('../components/home/HomeProductSectionThree.vue'));
// const HomeProductSectionFour = defineAsyncComponent(() => import('../components/home/HomeProductSectionFour.vue'));
// const HomeProductSectionFive = defineAsyncComponent(() => import('../components/home/HomeProductSectionFive.vue'));
// const HomeProductSectionSix = defineAsyncComponent(() => import('../components/home/HomeProductSectionSix.vue'));
// const HomeBannerSectionOne = defineAsyncComponent(() => import('../components/home/HomeBannerSectionOne.vue'));
// const HomeBannerSectionTwo = defineAsyncComponent(() => import('../components/home/HomeBannerSectionTwo.vue'));
// const HomeBannerSectionThree = defineAsyncComponent(() => import('../components/home/HomeBannerSectionThree.vue'));
// const HomeBannerSectionFour = defineAsyncComponent(() => import('../components/home/HomeBannerSectionFour.vue'));
// const HomeAboutText = defineAsyncComponent(() => import('../components/home/HomeAboutText.vue'));
// const HomeAllCategories = defineAsyncComponent(() => import('../components/home/HomeAllCategories.vue'));

import HomePopularCategories from "../components/home/HomePopularCategories.vue";
import HomeSliders from "../components/home/HomeSliders.vue";
import HomeProductSectionOne from "../components/home/HomeProductSectionOne.vue";
import HomeProductSectionTwo from "../components/home/HomeProductSectionTwo.vue";
import HomeProductSectionThree from "../components/home/HomeProductSectionThree.vue";
import HomeProductSectionFour from "../components/home/HomeProductSectionFour.vue";
import HomeProductSectionFive from "../components/home/HomeProductSectionFive.vue";
import HomeProductSectionSix from "../components/home/HomeProductSectionSix.vue";

import HomeBannerSectionOne from "../components/home/HomeBannerSectionOne.vue";
import HomeBannerSectionTwo from "../components/home/HomeBannerSectionTwo.vue";
import HomeBannerSectionThree from "../components/home/HomeBannerSectionThree.vue";
import HomeBannerSectionFour from "../components/home/HomeBannerSectionFour.vue";
import HomeAboutText from "../components/home/HomeAboutText.vue";
import HomeAllCategories from "../components/home/HomeAllCategories.vue";

// import HomeShopBannerSectionOne from "../components/home/HomeShopBannerSectionOne.vue";
// import HomeShopBannerSectionThree from "../components/home/HomeShopBannerSectionThree.vue";
// import HomeShopBannerSectionTwo from "../components/home/HomeShopBannerSectionTwo.vue";
// import HomeShopSectionFive from "../components/home/HomeShopSectionFive.vue";
// import HomeShopSectionFour from "../components/home/HomeShopSectionFour.vue";
// import HomeShopSectionOne from "../components/home/HomeShopSectionOne.vue";
// import HomeShopSectionThree from "../components/home/HomeShopSectionThree.vue";
// import HomeShopSectionTwo from "../components/home/HomeShopSectionTwo.vue";

export default {
  components: {
    HomeSliders,
    HomePopularCategories,
    HomeProductSectionOne,
    HomeProductSectionTwo,
    HomeProductSectionThree,
    HomeProductSectionFour,
    HomeProductSectionFive,
    HomeProductSectionSix,
    HomeBannerSectionOne,
    HomeBannerSectionTwo,
    HomeBannerSectionThree,
    HomeBannerSectionFour,
    HomeAboutText,
    HomeAllCategories,
    // HomeShopSectionOne,
    // HomeShopBannerSectionOne,
    // HomeShopSectionTwo,
    // HomeShopBannerSectionTwo,
    // HomeShopSectionThree,
    // HomeShopSectionFour,
    // HomeShopSectionFive,
    // HomeShopBannerSectionThree,
  },
  mounted() {
    this.$emit('loaded');
  },



};
</script>

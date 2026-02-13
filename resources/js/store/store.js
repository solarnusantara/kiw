import { createStore } from "vuex";
import addressModule from "./modules/address.js";
import affiliate from "./modules/affiliate.js";
import appModule from "./modules/app.js";
import authModule from "./modules/auth.js";
import cartModule from "./modules/cart.js";
import compareList from "./modules/compareList.js";
import deliveryboy from "./modules/deliveryboy.js";
import followModule from "./modules/follow.js";
import recentlyViewed from "./modules/recentlyViewed.js";
import snackBar from "./modules/snackbar.js";
import wishlistModule from "./modules/wishlist.js";
import aiChat from "./modules/aiChat.js";
const store = createStore({
    modules: {
        app: appModule,
        auth: authModule,
        address: addressModule,
        wishlist: wishlistModule,
        follow: followModule,
        cart: cartModule,
        snackbar: snackBar,
        recentlyViewed: recentlyViewed,
        compareList: compareList,
        affiliate: affiliate,
        deliveryboy: deliveryboy,
        aiChat: aiChat,
    },
});

export default store;

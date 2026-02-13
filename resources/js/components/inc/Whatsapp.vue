<script>
import Message from "./Message.vue";
import { mapGetters } from "vuex";
import ConversationBoxBot from "../conversation/ConversationBoxBot.vue";
export default {
    emits: ['loaded'],
  mounted() {
    this.$emit('loaded');
  },
  computed: {
    ...mapGetters("app", ["generalSettings"]),
    // contact_phone
  },

  components: {
    Message,
    ConversationBoxBot
  },
  data() {
    return {
      control: false,
      text: "",
      status: false,
    };
  },
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
    companyName: {
      type: String,
      default: "Sonus Hub",
    },
    textReply: {
      type: String,
      default: "Typically replies within an hour",
    },
    messagesWa: {
      type: Array,
      default: () => ["Hi there 👋 How can I help you ?"],
    },
    companyLogo: {
      type: String,
      default: "",
    },
    phoneNumber: {
      type: String,
      default: "",
    },
  },
  methods: {
    toggle() {
      this.status = !this.status;
    },
    validateText() {
      if (!this.text.trim()) {
        this.errorMessage = "Text field cannot be empty.";
        return false;
      }
      this.errorMessage = "";
      return true;
    },
    openLink() {
        if (!this.validateText()) {
        return;
      }
      let url = "https://wa.me/";
      if (
        /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
          navigator.userAgent
        )
      ) {
        url = "https://wa.me/";
      }
    const phone = this.generalSettings.contact_phone.replace(/[+\-\s]/g, '') || '';
    const all = url + phone + `?text=${encodeURIComponent(this.text || 'hello sonus').replace(/%0A/g, '%0a')}`;
    console.log(all);
      window.open(all, "_blank");
    },
  },
};
</script>
<template>
  <div id="wp-widget">
    <div v-if="control" id="whatsapp-chat" class="hidden">
      <div class="whatsapp-chat-header">
        <div class="whatsapp-chat-avatar">
          <img
            :src="static_asset('/assets/img/chat.svg')"
            height="30"
            />
        </div>
        <p class="whatsapp-chat-name-block">
          <span class="whatsapp-chat-name">{{ generalSettings.contact_phone }}</span
          ><br /><small>{{ textReply }}</small>
        </p>
      </div>

      <div class="start-chat">
        <div
          class="WhatsappChat__Component-sc-Yvjha whatsapp-chat-body"
        >
          <Message :msg="messagesWa" :companyName="companyName" />
        </div>
        <div class="blanter-msg">
          <textarea
            id="chat-input"
            placeholder="Write a response"
            maxlength="120"
            row="1"
            v-model="text"
          ></textarea>
          <button id="send-it" @click="openLink">
            <svg viewBox="0 0 448 448">
              <path d="M.213 32L0 181.333 320 224 0 266.667.213 416 448 224z" />
            </svg>
          </button>
        </div>
      </div>
      <a class="close-chat" @click="control = false">×</a>
    </div>
    <button
        class="yosu-chat"
        title="Start Chat"
        @click="control = !control"
        v-show="status"
    >
      <svg width="30" viewBox="0 0 24 24">
        <defs />
        <path
          fill="#eceff1"
          d="M20.5 3.4A12.1 12.1 0 0012 0 12 12 0 001.7 17.8L0 24l6.3-1.7c2.8 1.5 5 1.4 5.8 1.5a12 12 0 008.4-20.3z"
        />
        <path
          fill="#4caf50"
          d="M12 21.8c-3.1 0-5.2-1.6-5.4-1.6l-3.7 1 1-3.7-.3-.4A9.9 9.9 0 012.1 12a10 10 0 0117-7 9.9 9.9 0 01-7 16.9z"
        />
        <path
          fill="#fafafa"
          d="M17.5 14.3c-.3 0-1.8-.8-2-.9-.7-.2-.5 0-1.7 1.3-.1.2-.3.2-.6.1s-1.3-.5-2.4-1.5a9 9 0 01-1.7-2c-.3-.6.4-.6 1-1.7l-.1-.5-1-2.2c-.2-.6-.4-.5-.6-.5-.6 0-1 0-1.4.3-1.6 1.8-1.2 3.6.2 5.6 2.7 3.5 4.2 4.2 6.8 5 .7.3 1.4.3 1.9.2.6 0 1.7-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.3-.3-.6-.4z"
        />
      </svg>
    </button>
    <ConversationBoxBot v-show="status" />

    <div class="channel toogle" @click="toggle">
        <button v-show="!status" class="icon open">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40" fill="#4caf50">
          <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.26 1.12.28 2.33.43 3.57.43.55 0 1 .45 1 1v3.5c0 .55-.45 1-1 1C10.29 21 3 13.71 3 4.5 3 3.95 3.45 3.5 4 3.5H7.5c.55 0 1 .45 1 1 0 1.24.15 2.45.43 3.57.1.35.01.74-.26 1.02l-2.2 2.2z"/>
        </svg>
      </button>
      <button v-show="status" class="icon close">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
        </svg>
      </button>
    </div>
  </div>
</template>
<style>

.icon {
  margin-top: 15px;
}
.channel {
  position: fixed;
  width: 60px;
  height: 60px;
  right: 40px;
  bottom: 70px;
  color: #FFF;
  border-radius: 50px;
  text-align: center;
  font-size: 30px;
  box-shadow: 2px 2px 3px #999;
  z-index: 100;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #fff;
}
button {
  outline: none;
}
#wp-widget {
  font-family: --system-ui, "Lato", sans-serif;
  background: #f1f1f1;
}
a:link,
a:visited {
  color: #444;
  text-decoration: none;
  transition: all 0.4s ease-in-out;
}
h1 {
    /* text-align: center; */
    font-size: 30px;
    display: block;
    padding: 10px;
  /*
  background: linear-gradient(to right top, #6f96f3, #164ed2);
  color: #fff; */
  /* border-radius: 50px; */
}
/* CSS Multiple Whatsapp Chat */
#whatsapp-chat {
  box-sizing: border-box !important;
  outline: none !important;
  position: fixed;
  width: 350px;
  border-radius: 10px;
  box-shadow: 0 1px 15px rgba(32, 33, 36, 0.28);
  bottom: 90px;
  right: 30px;
  overflow: hidden;
  z-index: 99;
  animation-name: showchat;
  animation-duration: 1s;
  transform: scale(1);
  z-index: 500;
}
button.yosu-chat {
  /* background: #009688;
	 */
  background: #fff;
  color: #404040;
  position: fixed;
  display: flex;
  font-weight: 400;
  justify-content: space-between;
  z-index: 98;
  bottom: 140px;
    right: 40px;

    @media screen and (max-width: 480px) {
        right: 20px;
    }
  font-size: 15px;
  padding: 15px 15px;
  border-radius: 50%;
  border: 1px solid transparent;
  box-shadow: 0 10px 10px rgba(32, 33, 36, 0.28);
  cursor: pointer;
}
button.ai-chat {
  border: none;
  cursor: pointer;
    background: #fff;
  color: #404040;
  position: fixed;
  display: flex;
  font-weight: 400;
  position: fixed;
  bottom: 210px;
  right: 40px;
  border: none;
  cursor: pointer;
 z-index: 98;
    @media screen and (max-width: 480px) {
        right: 20px;
    }
font-size: 15px;
  padding: 15px 15px;
  border-radius: 50%;
  border: 1px solid transparent;
  box-shadow: 0 10px 10px rgba(32, 33, 36, 0.28);
  cursor: pointer;
}
button.yosu-chat svg {
  transform: scale(1.2);
}
.whatsapp-chat-header {
  background: #095e54;
  display: inline-flex;
  align-items: center;
  padding-left: 10px;
  height: 60px;
  width: 100%;
  height: 100%;
  color: #fff;
}
.companyLogo {
  border-radius: 100%;
  width: 50px;
  height: 50px;
  float: left;
  margin: 0 10px 0 0;
  border: 1px solid rgba(0, 0, 0, 0.2);
}
.whatsapp-chat-avatar {
  position: relative;
}
.whatsapp-chat-avatar::after {
  content: "";
  bottom: 0px;
  right: 0px;
  width: 12px;
  height: 12px;
  box-sizing: border-box;
  background-color: #4ad504;
  display: block;
  position: relative;
  z-index: 1;
  border-radius: 50%;
  border: 2px solid #095e54;
  left: 40px;
  top: 38px;
}
.whatsapp-chat-avatar img {
  border-radius: 100%;
  width: 50px;
  float: left;
  margin: 0 10px 0 0;
}
.whatsapp-chat-name-block {
  text-align: left;
}
.info-chat span {
  display: block;
}
#get-label,
span.chat-label {
  font-size: 12px;
  color: #888;
}
#get-nama,
span.chat-nama {
  margin: 5px 0 0;
  font-size: 15px;
  font-weight: 700;
  color: #222;
}
#get-label,
#get-nama {
  color: #fff;
}
span.my-number {
  display: block;
}
.blanter-msg {
	 color: #444;
     background: #fff;
	 /* padding: 20px; */
	 font-size: 12.5px;
	 text-align: center;
	 border-top: 1px solid #ddd;
}

textarea#chat-input {
  border: none;
  font-family: "Arial", sans-serif;
  width: 100%;
  outline: none;
  resize: none;
  padding: 8px;
  font-size: 14px;
}
button#send-it {
  width: 30px;
  font-weight: 700;
  border-color: transparent;
  cursor: pointer;
  background: #eee;
}
button#send-it svg {
  fill: #a6a6a6;
  height: 20px;
  width: 20px;
}
.start-chat .blanter-msg {
  display: flex;
  height: 35px;
}
a.close-chat {
  position: absolute;
  top: 0px;
  right: 15px;
  color: #fff;
  font-size: 30px;
  cursor: pointer;
}
@keyframes ZpjSY {
  0% {
    background-color: #b6b5ba;
  }
  15% {
    background-color: #111;
  }
  25% {
    background-color: #b6b5ba;
  }
}
@keyframes hPhMsj {
  15% {
    background-color: #b6b5ba;
  }
  25% {
    background-color: #111;
  }
  35% {
    background-color: #b6b5ba;
  }
}
@keyframes iUMejp {
  25% {
    background-color: #b6b5ba;
  }
  35% {
    background-color: #111;
  }
  45% {
    background-color: #b6b5ba;
  }
}
@keyframes showhidden {
  from {
    transform: scale(0.5);
    opacity: 0;
  }
}
@keyframes showchat {
  from {
    transform: scale(0);
    opacity: 0;
  }
}
@media screen and (max-width: 480px) {
  #whatsapp-chat {
    width: auto;
    left: 5%;
    right: 5%;
    font-size: 80%;
  }
}
.hidden {
  display: block;
  animation-duration: 0.5s;
  transform: scale(1);
  opacity: 1;
}
.show {
  display: block;
  animation-name: showhidden;
  animation-duration: 0.5s;
  transform: scale(1);
  opacity: 1;
}
.whatsapp-chat-body {
  padding: 20px 20px 20px 10px;
  background-color: #e6ddd4;
  position: relative;
}
.whatsapp-chat-body::before {
  display: block;
  position: absolute;
  content: "";
  left: 0px;
  top: 0px;
  height: 100%;
  width: 100%;
  z-index: 0;
  opacity: 0.08;
  background-image: url("https://elfsight.com/assets/chats/patterns/whatsapp.png");
}
.quaMo {
  z-index: 1;
}
.vzZsj {
  background-color: #fff;
  width: 52.5px;
  border-radius: 16px;
  display: flex;
  -moz-box-pack: center;
  justify-content: center;
  -moz-box-align: center;
  align-items: center;
  margin-left: 10px;
  opacity: 0;
  transition: all 0.1s ease 0s;
  z-index: 1;
  box-shadow: rgba(0, 0, 0, 0.13) 0px 1px 0.5px;
}
.Yvjha {
  position: relative;
  display: flex;
}
.ixsrax {
  height: 5px;
  width: 5px;
  margin: 0px 2px;
  border-radius: 50%;
  display: inline-block;
  position: relative;
  animation-duration: 1.2s;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
  top: 0px;
  background-color: #9e9da2;
  animation-name: ZpjSY;
}
.dRvxoz {
  height: 5px;
  width: 5px;
  margin: 0px 2px;
  background-color: #b6b5ba;
  border-radius: 50%;
  display: inline-block;
  position: relative;
  animation-duration: 1.2s;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
  top: 0px;
  animation-name: hPhMsj;
}
.kAZgZq {
  padding: 7px 14px 6px;
  background-color: #fff;
  border-radius: 0px 12px 12px;
  position: relative;
  transition: all 0.3s ease 0s;
  opacity: 0;
  transform-origin: center top 0px;
  z-index: 2;
  box-shadow: rgba(0, 0, 0, 0.13) 0px 1px 0.5px;
  margin-top: 20px;
  max-width: calc(100% - 66px);
}
.kAZgZq::before {
  position: absolute;
  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAmCAMAAADp2asXAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAACQUExURUxpccPDw9ra2m9vbwAAAAAAADExMf///wAAABoaGk9PT7q6uqurqwsLCycnJz4+PtDQ0JycnIyMjPf3915eXvz8/E9PT/39/RMTE4CAgAAAAJqamv////////r6+u/v7yUlJeXl5f///5ycnOXl5XNzc/Hx8f///xUVFf///+zs7P///+bm5gAAAM7Ozv///2fVensAAAAvdFJOUwCow1cBCCnqAhNAnY0WIDW2f2/hSeo99g1lBYT87vDXG8/6d8oL4sgM5szrkgl660OiZwAAAHRJREFUKM/ty7cSggAABNFVUQFzwizmjPz/39k4YuFWtm55bw7eHR6ny63+alnswT3/rIDzUSC7CrAziPYCJCsB+gbVkgDtVIDh+DsE9OTBpCtAbSBAZSEQNgWIygJ0RgJMDWYNAdYbAeKtAHODlkHIv997AkLqIVOXVU84AAAAAElFTkSuQmCC");
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-size: contain;
  content: "";
  top: 0px;
  left: -12px;
  width: 12px;
  height: 19px;
}
.bMIBDo {
  font-size: 13px;
  font-weight: 700;
  line-height: 18px;
  text-align: left;
  color: rgba(0, 0, 0, 0.4);
}
.iSpIQi {
  font-size: 14px;
  line-height: 19px;
  margin-top: 4px;
  color: #111;
  text-align: left;
}
.cqCDVm {
  text-align: right;
  margin-top: 4px;
  font-size: 12px;
  line-height: 16px;
  color: rgba(17, 17, 17, 0.5);
  margin-right: -8px;
  margin-bottom: -4px;
}
</style>

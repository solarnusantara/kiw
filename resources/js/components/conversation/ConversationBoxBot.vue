<template>
  <div>
    <button
      class="ai-chat"
      title="Chat with AI"
      @click="openChatWindowAi"
    >
    <svg width="30" viewBox="0 0 24 24">
      <path
        fill="#4caf50"
        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
      />
    </svg>
    </button>
    <div v-if="dialog" class="modal-overlay" @click.self="closeChatWindow">
        <div class="modal">
                <div class="chat">
                    <div class="chat_header">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        Sona
                        <div class="chat_status">ONLINE</div>
                        <button class="close_chat" @click="closeChatWindow">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                        </button>
                    </div>
                    <div class="chat_s" ref="chatListBot">
                        <div v-for="message in botMessages" :class="message.type === 'bot' ? 'chat_bubble-2' : 'chat_bubble-1'" :key="message.text">
                        {{ message.text }}
                        </div>
                    </div>
                    <div class="chat_input">
                        <input placeholder="Type here..." class="chat_text" @keypress.enter="sendMessage" v-model="newMessage" ref="messageInput" />
                        <button @click="sendMessage" class="chat_submit fa fa-send">
                        <svg v-if="!isLoading" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M2 21l21-9-21-9v7l15 2-15 2v7z"/>
                        </svg>
                        <div v-else class="loader"></div>
                        </button>
                    </div>
                </div>
        </div>
    </div>
  </div>
</template>

<script>
import { mapMutations,mapGetters } from 'vuex';

export default {
  data() {
    return {
      dialog: false,
      newMessage: '',
      botMessages: [],
      sending: false,
      isLoading: false,
    };
  },
  computed: {
    // ...mapGetters('chat', ['messages']),
  },
  methods: {
    ...mapMutations("auth", ["updateChatWindowAi"]),
    // ...mapMutations('chat', ['addMessage', 'setMessages', 'clearMessages']),
    openChatWindowAi() {
      this.dialog = true;
      this.updateChatWindowAi(true);
    //   if (this.isAuthenticated) {
        // this.getOldChats();
        // this.getNewMessages();
    //   }
    },
    closeChatWindow() {
      this.updateChatWindowAi(false);
      this.dialog = false;
    },
    async sendMessage() {
      if (!this.newMessage.trim()) {
        return;
      }
      this.sending = true;
    //   if (this.isAuthenticated && this.newMessage.trim()) {
    //     const chat = { message: this.newMessage };
    //     const res = await this.call_api("post", "chats/sonia/send", chat);
    //     // console.log(res);
    //     if (res.data.success) {
    //       this.newMessage = "";
    //       // console.log("msg",res.data.data);
    //       this.botMessages.push(res.data.data);
    //       this.chatScrollToBottomAi();
    //     } else {
    //       this.snack({ message: res.data.message });
    //     }
    //     this.sending = false;
    //   }
    //   else {

        const messageToSend = this.newMessage; // Save the message temporarily
        this.newMessage = '';

        this.botMessages.push({ text: messageToSend, type: 'user' });
        this.sending = true;

        this.isLoading = true;
        const chat = { message: messageToSend };

        try {
            const res = await this.call_api("post", "chats/sonia/send", chat);
            this.newMessage = '';
            if (res.data.success) {
            this.botMessages.push({ text: res.data.data.message, type: 'bot' });
            this.newMessage = '';
            this.chatScrollToBottomAi();
            } else {
            this.snack({ message: res.data.message });
            }
            this.sending = false;
        } catch (error) {
            console.error("Error sending message:", error);
        } finally {
            this.isLoading = false; // Hide loader
        }

    //   }
    },
    // async getOldChats() {
    //   const res = await this.call_api("get", "user/chats");
    //   if (res.data.success) {
    //     this.botMessages = res.data.data.data;
    //     this.chatScrollToBottomAi();
    //   }
    // },
    chatScrollToBottomAi() {
      setTimeout(() => {
        const el = this.$refs.chatListBot.lastElementChild;
        if (el) {
          el.scrollIntoView({ behavior: "smooth" });
        }
      }, 100);
    },
    // getNewMessages() {
    //   setInterval(async () => {
    //     const res = await this.call_api("get", "user/chats/new-messages");
    //     if (res.data.success && res.data.data.data.length > 0) {
    //       this.botMessages = [...this.botMessages, ...res.data.data.data];
    //       this.chatScrollToBottomAi();
    //     }
    //   }, 5000);
    // },
  },
};
</script>

<style scoped>
.chat {
  width: 100%;
  height: 60vh;
  position: relative;
  font-family: "Montserrat", sans-serif;
}
.chat_header {
  padding: 10px;
  font-weight: bold;
  background: #4caf50;
  color: white;
  border-radius: 5px 5px 0 0;
  display: flex;
  align-items: center;
}
.chat_header svg {
  margin-right: 10px;
}
.chat_status {
  font-size: 11px;
  margin-left: auto;
  display: flex;
  align-items: center;
}
.close_chat {
  margin-left: 10px;
  align-items: center;
  background: none;
  border: none;
  cursor: pointer;
}
.chat_s {
  padding: 10px;
  overflow-y: auto;
  height: calc(100% - 100px);
}
.chat_bubble-1,
.chat_bubble-2 {
  padding: 10px;
  margin: 5px 0;
  border-radius: 10px;
  max-width: 80%;
}
.chat_bubble-1 {
    background: #e0e0e0;
    align-self: flex-end;
    text-align: right;
    margin-left: auto;
}
.chat_bubble-2 {
  background: #4caf50;
  color: white;
  align-self: flex-start;
}
.chat_input {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 10px;
    background: #f1f1f1;
    display: flex;
    align-items: center;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}
.chat_text {
  width: calc(85% - 10px);
  padding: 10px;
  box-sizing: border-box;
  margin: 0 5px 5px;
  vertical-align: top;
  font-family: "Montserrat", sans-serif;
}
.chat_submit {
  background: none;
  border: none;
  cursor: pointer;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal {
  background: white;
  border-radius: 8px;
  /* padding: 20px; */
  width: 600px;
  max-width: 100%;
}
.loader {
  border: 2px solid #f3f3f3;
  border-top: 2px solid #4caf50;
  border-radius: 50%;
  width: 16px;
  height: 16px;
  animation: spin 1s linear infinite;
  margin: auto;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

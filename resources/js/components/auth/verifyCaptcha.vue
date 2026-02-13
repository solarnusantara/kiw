<template>
  <div class="captcha-container mb-2">
    <label>
      <input type="checkbox" v-model="showCaptcha" @change="generateCaptcha" />
      I'm not a robot
    </label>

    <div v-if="showCaptcha" class="captcha-box">
      <img :src="captchaImage" alt="CAPTCHA" />
      <button @click="generateCaptcha" class="refresh-button">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(2px 2px 2px #ffff);">
              <path d="M18.6091 5.89092L15.5 9H21.5V3L18.6091 5.89092ZM18.6091 5.89092C16.965 4.1131 14.6125 3 12 3C7.36745 3 3.55237 6.50005 3.05493 11M5.39092 18.1091L2.5 21V15H8.5L5.39092 18.1091ZM5.39092 18.1091C7.03504 19.8869 9.38753 21 12 21C16.6326 21 20.4476 17.5 20.9451 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
      </button>
      <input
        type="text"
        v-model="userInput"
        placeholder="Enter the text shown above"
        @input="debouncedVerifyCaptcha"
        />
      <!-- <button @click="verifyCaptcha">Verify</button> -->
    </div>

    <p v-if="verificationMessage" :class="{ 'success': isVerified, 'error': !isVerified }">
      {{ verificationMessage }}
    </p>
  </div>
</template>

<script>
import { debounce } from 'lodash';
export default {
  data() {
    return {
      showCaptcha: false,
      captchaText: "",
      captchaImage: "",
      userInput: "",
      verificationMessage: "",
      isVerified: false,
    };
  },
  methods: {
    generateRandomText(length) {
      const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      return Array.from({ length }, () => characters.charAt(Math.floor(Math.random() * characters.length))).join('');
    },
    generateCaptcha() {
      if (!this.showCaptcha) return;
      this.captchaText = this.generateRandomText(6);
      this.captchaImage = this.createCaptchaImage(this.captchaText);
    },
    createCaptchaImage(text) {
      const canvas = document.createElement("canvas");
      canvas.width = 200;
      canvas.height = 80;
      const ctx = canvas.getContext("2d");
      ctx.fillStyle = this.getRandomColor();
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      for (let i = 0; i < 100; i++) {
        ctx.fillStyle = this.getRandomColor();
        ctx.beginPath();
        ctx.arc(Math.random() * canvas.width, Math.random() * canvas.height, Math.random() * 3, 0, Math.PI * 2);
        ctx.fill();
      }

      for (let i = 0; i < 5; i++) {
        ctx.strokeStyle = this.getRandomColor();
        ctx.lineWidth = Math.random() * 3;
        ctx.beginPath();
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.stroke();
      }

      ctx.font = "bold 40px Arial";
      ctx.fillStyle = this.getRandomColor();
      ctx.textBaseline = "middle";
      ctx.textAlign = "center";

      text.split("").forEach((char, index) => {
        const x = 30 + index * 30 + Math.random() * 10;
        const y = canvas.height / 2 + (Math.random() * 20 - 10);
        const angle = (Math.random() - 0.5) * Math.PI / 4;

        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(angle);
        ctx.fillText(char, 0, 0);
        ctx.restore();
      });

      return canvas.toDataURL("image/png");
    },
    getRandomColor() {
      const letters = "0123456789ABCDEF";
      return `#${Array.from({ length: 6 }, () => letters[Math.floor(Math.random() * 16)]).join('')}`;
    },
    verifyCaptcha() {
    if (!this.userInput.trim()) {
      this.verificationMessage = "Please enter the CAPTCHA text.";
      this.isVerified = false;
    } else if (this.userInput.toLowerCase() === this.captchaText.toLowerCase()) {
      this.verificationMessage = "CAPTCHA verified successfully!";
      this.isVerified = true;
    //   this.$emit('verified', this.isVerified);
    } else {
      this.verificationMessage = "CAPTCHA verification failed. Please try again.";
      this.isVerified = false;
      this.generateCaptcha();
      this.userInput = "";
    }
    this.$emit('verified', { isVerified: this.isVerified, message: this.verificationMessage });
    },
    debouncedVerifyCaptcha: debounce(function () {
      this.verifyCaptcha();
    }, 500),
  },
};
</script>

<style scoped>
.captcha-container {
  max-width: 300px;
  margin: left;
  text-align: left;

}
.captcha-box {
  margin-top: 1em;
      position: relative;
  display: inline-block;
}
.captcha-container img {
  display: block;
}

.refresh-button {
  position: absolute;
  top: 0;
  right: 5px;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 0;
}
img {
  margin-bottom: 0.5em;
}
.success {
  color: green;
}
.error {
  color: red;
}
</style>

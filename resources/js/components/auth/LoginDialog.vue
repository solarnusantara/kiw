<template>
    <div v-if="!isAuthenticated">
        <v-dialog
            v-model="showLogin"
            width="1000"
            @click:outside="hideLogin"
        >
            <LoginForm/>
        </v-dialog>
    </div>
</template>

<script>
import LoginForm from './LoginForm.vue'
import {mapGetters,mapMutations} from "vuex";
export default {
    data: () =>({
    }),
    emits: ['loaded'],
    mounted() {
        this.$emit('loaded');
    },
    components: { LoginForm },
    computed:{
        ...mapGetters('auth', {
            showLogin: 'showLoginDialog',
            isAuthenticated: 'isAuthenticated'
        }),
    },
    methods:{
        ...mapMutations('auth',[
            'showLoginDialog'
        ]),
        hideLogin(){
            this.showLoginDialog(false)
        }
    }
}
</script>

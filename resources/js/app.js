
require('./bootstrap');

window.Vue = require('vue');

import MessageComponent from './components/message.vue'

import VueChatScroll from 'vue-chat-scroll'

import Axios from 'axios';
import Toaster from 'v-toaster'
Vue.use(Toaster, {timeout: 5000})
import 'v-toaster/dist/v-toaster.css'


Vue.use(VueChatScroll)
Vue.component('message', MessageComponent);


const app = new Vue({
    el: '#app',
    data: {
        message: '',
        chat: {
            message: [],
            user: [],
            color: [],
            time: []
        },
        typing: '',
        numberOfUsers:0
    },
    watch: {
        message() {
            Echo.private('chat')
                .whisper('typing', {
                    name: this.message
                });
        }
    },
    methods: {
        send() {
            if (this.message.length != 0) {
                this.chat.message.push(this.message);
                this.chat.user.push('You');
                this.chat.color.push('success');
                this.chat.time.push(this.getTime());
                axios.post('/send', {
                    message: this.message,
                    chat:this.chat
                }).then(res => {
                    console.log(res);
                    this.message = '';
                })
                    .catch(error => {
                        console.log(error);
                    });


            }

        },
        getTime() {
            let time = new Date();
            return time.getHours() + ':' + time.getMinutes();
        },
        getOldMessages(){
            axios.get('/getOldMessages')
            .then(res=>{
                if(res.data!='')
                this.chat=res.data;
            })
        },
        deleteSession(){
            axios.post('/deleteSession')
            .then(()=>{
                this.chat=[];
                this.$toaster.success('Chat history is deleted')

            });
        }
    },
    mounted() {


        this.getOldMessages();
        Echo.private('chat')
            .listen('ChatEvent', (e) => {
                this.chat.message.push(e.message);
                this.chat.user.push(e.user);
                this.chat.color.push('warning');
                this.chat.time.push(this.getTime());
                axios.post('/saveToSession',{
                    chat:this.chat
                });

                console.log(e);
            })
            .listenForWhisper('typing', (e) => {
                if (e.name != '') {
                    this.typing = 'typing...'
                } else {
                    this.typing = ''
                }
            });
        Echo.join(`chat`)
            .here((users) => {
                this.numberOfUsers=users.length
            })
            .joining((user) => {
                this.numberOfUsers++;
                this.$toaster.success(user.name+' joined the room')

            })
            .leaving((user) => {
                this.numberOfUsers--;
                this.$toaster.warning(user.name+' left the room')

            });
    }
});

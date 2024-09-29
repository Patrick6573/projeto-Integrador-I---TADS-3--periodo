<template>

    <h1> Chat</h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex" style="min-height: 400px; max-height:400px;">
                <!-- Liste de Usuarios -->
                <div class="w-3/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                    <ul>
                        <li v-for="user in users" :key="user.id"
                        @click="() => {loadMessages(user.id)}"
                        :class="(userActive && userActive.id == user.id) ? 'bg-gray-200 bg-opacity-50': ''"
                         class="p-6 text-lg text-gray-600 leading-7 font-semibold border-b border-gray-200 hover:bg-gray-200 hover:bg-opacity-50 hover:cursor-pointer w-full">
                            <p class="flex items-center">
                                {{user.name}}
                                <span  v-if="user.notification" class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                            </p>
                        </li>

                    </ul>
                </div>
                
                
                <!-- Caixa de conversas -->
                
                <div class="w-9/12 flex flex-col justify-between overflow-y-scroll" >

                    <div 
                    v-for="message in messages" :key="message.id"
                    :class="(message.fk_id_user_from === $page.props.auth.user.id) ? ' text-right' : 'text-left'"
                    class="w-full p-6 flex flex-col">
                        <div class="w-full mb-3" >
                            <p
                            :class="(message.fk_id_user_from === $page.props.auth.user.id) ? 'messageFromMe': 'messageToMe'"
                             class="inline-block p-2 rounded-md" style="max-width: 75%;">
                                {{message.content}}
                            </p>
                            <span  class="block mt-1 text-xs text-gray-500">
                                <p v-if="(message.fk_id_user_from === $page.props.auth.user.id)">
                                    {{formatTime(message.shipping_date, message.shipping_time) }}</p> 
                                    <p v-else>{{formatTime(message.date_received, message.time_received) }}</p> 
                                
                            </span>

                        </div>

                    </div>


                    <div v-if="userActive"
                    class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200 message " >
                        <form v-on:submit.prevent="sendMessage">
                            <div class="flex rounded-md overflow-hidden border border-gray-300">
                                <input v-model="message"type="text" class="flex-1 px-4 py-2 text-sm focus:outline-none">
                                <button type="submit" class=" bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2">
                                    Enviar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- Botão de enviar -->


            </div>
        </div>
    </div>



</template>

<script>
    //import Name from '@/components/Name.vue';
    import moment from 'moment';
    import store from '../store';
    import Pusher from 'pusher-js';

    moment.locale('pt-br');
    
    export default {
    components: {},
    data() {
        return {
            users: [],
            messages: [],
            userActive: null,
            message: ''
        };
    },
    computed:{
        user(){
            return store.state.user
        }
    },
    methods: {
        scrollToBotton: function() {
            if (this.messages.length) {
                const lastMessage = document.querySelector('.message:last-child');
                if (lastMessage) {
                    lastMessage.scrollIntoView();
                }
            }
        },
        loadMessages: function(userId) {
            
            axios.get(`web/users/${userId}`).then(response =>{
                this.userActive = response.data.user

            })
            axios.get(`web/messages/${userId}`).then(response =>{
                this.messages = response.data.messages;
                this.$nextTick(() => {
                    this.scrollToBotton();
                });

            });     
            
        },
        formatTime(date, time) {
            const combined = moment(`${date} ${time}`, 'YYYY-MM-DD HH:mm');
            return combined.isValid() ? combined.format('DD-MM-YYYY HH:mm') : 'Hora inválida';
        },

        sendMessage: async function(){
            await axios.post('web/messages/store', {
                'content': this.message,
                'to': this.userActive.id
            }).then(response =>{
                const currentDate = new Date();
                this.messages.push({
                    'fk_id_user_from': this.user.id,
                    'fk_id_user_to' : this.userActive.id,
                    'shipping_date': currentDate.toISOString(), 
                    'shipping_time': currentDate.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }),
                    'date_received' : currentDate.toISOString(),
                    'time_received' : currentDate.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }),
                    'content': this.message

                })
                this.message = '';
                
            })
            this.scrollToBotton()
        },
    
    },
    mounted() { 
        

         axios.get('web/users')
        .then(response => {
            this.users = response.data.users; 
        })
        .catch(error => {
            console.error('Erro ao buscar usuários:', error); 
        });

        Echo.private(`user.${this.user.id}`).listen('.SendMessage',async (e) => {

            if(this.userActive && this.userActive.id === e.message.fk_id_user_from){
                console.log(e);
                await this.messages.push(e.message);
                this.scrollToBotton();
            }
            else{
                 const user = this.users.filter((user) =>{
                     if(user.id === e.message.fk_id_user_from){
                         return user
                     }
                 })
                 if(user){
                     user.notification = true;
                     Vue.set(user[0], 'notifcation', true)
                 }
             }
        });
}}


    
</script>
<style>
.messageFromMe{
    @apply bg-indigo-300 bg-opacity-25;
}
.messageToMe{
    @apply bg-gray-300 bg-opacity-25;
}

</style>
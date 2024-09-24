// store.js

import { createStore } from 'vuex';
import axios from 'axios';
import createPersistedState from 'vuex-persistedstate';

export default createStore({
    state: {
        user: {}
    },
    mutations: {
        setUserState: (state, value) => {
            state.user = value;
        }
    },
    actions: {
        userStateAction: ({ commit }) => { // Extraindo o 'commit'
            axios.get('web/user/me')
                .then(response => {
                    const userResponse = response.data.user;
                    commit('setUserState', userResponse); // Usando 'commit' corretamente
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                });
        }
    },
    plugins: [createPersistedState()]
});

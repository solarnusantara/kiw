import axios from 'axios';

const state = {
    banks: []
};

const getters = {
    availableBanks: state => state.banks
};

const actions = {
    async fetchBanks({ commit }) {
        try {
            const response = await axios.get('https://api.xendit.co/available_virtual_account_banks', {
                auth: {
                    username: 'YOUR_SECRET_API_KEY',
                    password: ''
                }
            });
            commit('setBanks', response.data);
        } catch (error) {
            // console.error('Error fetching banks:', error);
        }
    }
};

const mutations = {
    setBanks: (state, banks) => (state.banks = banks)
};

export default {
    state,
    getters,
    actions,
    mutations
};

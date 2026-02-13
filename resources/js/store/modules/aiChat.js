const state = {
    messages: JSON.parse(sessionStorage.getItem('chatMessages')) || [],
};

const mutations = {
    ADD_MESSAGE(state, message) {
        state.messages.push(message);
        sessionStorage.setItem('chatMessages', JSON.stringify(state.messages));
    },
    SET_MESSAGES(state, messages) {
        state.messages = messages;
        sessionStorage.setItem('chatMessages', JSON.stringify(state.messages));
    },
    CLEAR_MESSAGES(state) {
        state.messages = [];
        sessionStorage.removeItem('chatMessages');
    },
};

const actions = {
    addMessage({ commit }, message) {
        commit('ADD_MESSAGE', message);
    },
    setMessages({ commit }, messages) {
        commit('SET_MESSAGES', messages);
    },
    clearMessages({ commit }) {
        commit('CLEAR_MESSAGES');
    },
};

const getters = {
    messages: (state) => state.messages,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
};

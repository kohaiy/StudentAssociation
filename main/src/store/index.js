import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

const store = new Vuex.Store({
  plugins: [createPersistedState()],
  state: {
    token: '',
    lastAuthTime: Date.now(),
    user: {},
  },
  mutations: {
    token(state, val) {
      state.token = val;
    },
    lastAuthTime(state, val) {
      state.lastAuthTime = val;
    },
    user(state, val) {
      state.user = val;
    },
  },
});

export default store;

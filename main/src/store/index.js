import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

const store = new Vuex.Store({
  plugins: [createPersistedState()],
  state: {
    token: '',
    lastAuthTime: Date.now(),
    user: null,
    unreadBadge: {
      all: 0,
      system: 0,
      whisper: 0,
    },
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
    unread(state, { system, whisper } = {}) {
      if (system === 0 || system) {
        state.unreadBadge.system = system;
      }
      if (whisper === 0 || whisper) {
        state.unreadBadge.whisper = whisper;
      }
      state.unreadBadge.all = state.unreadBadge.system + state.unreadBadge.whisper;
    },
  },
});

export default store;

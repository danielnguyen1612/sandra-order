import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    items: [],
  },
  mutations: {
    ADD_ITEM(state, data) {
      state.items = [...state.items, {
        ...data,
        notes: '',
        textItems: data.items.map(v => `${v.quantity} ${v.type} ${v.size} ${v.colors.join(',')}`)
      }];
    },

    UPDATE_NOTES(state, {idx, val}) {
      const item = {
        ...state.items[idx],
        notes: val,
      }
      state.items.splice(idx, 1, item);
    },

    REMOVE_ITEM(state, data) {
      state.items.splice(data, 1);
    },

    RESET_ITEMS(state) {
      state.items = [];
    }
  },
  actions: {},
  getters: {
    getItems: state => state.items,
  }
});

export default store;

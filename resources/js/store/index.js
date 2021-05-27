import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedStore from 'vuex-persistedstate';

Vue.use(Vuex);

const store = new Vuex.Store({
  plugins: [createPersistedStore({
    storage: window.sessionStorage,
    paths: [
      'items'
    ]
  })],
  state: {
    items: [],
    itemEdit: null,
  },
  mutations: {
    ADD_ITEM(state, data) {
      state.items = [...state.items, {
        ...data,
        notes: '',
        textItems: data.items.map(v => `${v.quantity} ${v.type} ${v.size} ${v.colors.join(',')}`)
      }];
    },

    EDIT_ITEM(state, idx) {
      state.itemEdit = idx;
    },

    CANCEL_EDIT(state) {
      state.itemEdit = null;
    },

    UPDATE_NOTES(state, {idx, val}) {
      const item = {
        ...state.items[idx],
        notes: val,
      }
      state.items.splice(idx, 1, item);
    },

    UPDATE_ITEM(state, {idx, data}) {
      state.items.splice(idx, 1, {
        ...data,
        notes: '',
        textItems: data.items.map(v => `${v.quantity} ${v.type} ${v.size} ${v.colors.join(',')}`)
      });
      state.itemEdit = null;
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
    itemEdit: state => state.itemEdit
  }
});

export default store;

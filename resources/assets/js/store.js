import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const searchModule = {
  state: {
    item: 'thisIsItem',
    desc: 'zheshidewc',
    make: 'make',
    year: 1970
  },
  mutations: {
    setItem(state, item) {
      state.item = item;
    },
    setDesc(state, desc) {
      state.desc = desc;
    },
    setMake(state, make) {
      state.make = make;
    },
    setYear(state, year) {
      state.year = year;
    }
  }
};

export const store = new Vuex.Store({
  state: {
    carts_total: 0,
    loginStatus: false,
    loginDirect: '/',
    confirm: false,
    captcha: ''
  },

  mutations: {
    carts_number(state, number) {
      state.carts_total = number;
    },
    changeLoginStatus(state, status) {
      state.loginStatus = status;
    },
    changeLoginDirect(state, direction) {
      state.loginDirect = direction;
    },
    confirm(state, ifConfirm) {
      state.confirm = ifConfirm;
    },
    captcha(state, captcha) {
      state.captcha = captcha;
    }
  },

  // filters: {
  //   decimal: function (value) {
  //     if (!isNaN(value)) {
  //       return value.toFixed(2)
  //     }else {
  //       return value
  //     }
  //   }
  // },
  modules: {
    search: searchModule
  }

});

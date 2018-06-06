export const myMixin = {
  data() {
    return {
      storage: window.localStorage
    };
  },
  methods: {
    addToCart: function () {},

    addToWishlist: function () {
      var user = this.storage.getItem('user');

      if (user) {
          alert(123);
      }else {
        var currentPath = this.$route.path;
        this.$store.commit('changeLoginDirect',currentPath);
        this.$router.push('login');
      }
    },
    currentPath: function () {
      console.log(this.$route.path);
    }
  },
  computed: {

  }
};

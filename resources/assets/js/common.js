export const myMixin = {
  data() {
    return {
      storage: window.localStorage
    };
  },
  mounted() {},
  methods: {
    addToCart: function () {
      console.log('this is test add to cart function');
    },

    addToWishlist: function (item) {
      if (this.storage.getItem('user')) {
        var user = JSON.parse(this.storage.getItem('user')).id;

        this.$http.post('/api/addToWishlist', {user: user, item: item}).then(response => {
          if (response.data.status == 'saved') {
            const h = this.$createElement;
            this.$notify({
              title: 'Succsesfully.',
              message: h('b', { style: 'color: teal' }, 'The item has been already put into Wishlist')
            });
          }else {
            const h = this.$createElement;
            this.$notify({
              title: 'Already in yor wishlist.',
              message: h('b', { style: 'color: teal' }, 'The item has been already in your Wishlist')
            });
          }
        }, response => {
          console.log('something error');
        });
      }else {
        var currentPath = this.$route.path;

        this.$store.commit('changeLoginDirect', currentPath);
        this.$router.push('/login');
      }
    },

    // addToCart
    addToCart_common(item) {
      if (item.onhand < 1) {
        this.$alert('Out of stock', 'Warning', {
          confirmButtonText: 'OK'
        });
      } else {
        if (window.localStorage.getItem(item.item)) {
          var qty = parseInt(window.localStorage.getItem(item.item)) + 1;
          window.localStorage.setItem(item.item, qty);
        } else {
          window.localStorage.setItem(item.item, 1);

          var newNumber = this.carts_number + 1;

          this.$store.commit('carts_number', newNumber);
        }
        const h = this.$createElement;
        this.$notify({
          title: 'Succsesfully.',
          message: h('b', { style: 'color: teal' }, 'The item has been already put into shopping cart')
        });
      }
    },

    currentPath: function () {
      console.log(this.$route.path);
    },

    customerOrderHistory: function () {
      var id = JSON.parse(this.storage.getItem('user')).id;
      this.$http.get('/api/customerOrderHistory', { params: { 'id': id } }).then(response => {
        this.orderHistory = response.data.history;
        this.pending = response.data.pending;
      });
    },

    viewed: function (item) {
      this.$http.post('/api/viewed', { 'item': item }).then(response => {
        console.log(response);
      });
    },



    oneOrderDetails: function (so, id) {}

  },
  computed: {
    carts_number() {
      return this.$store.state.carts_total;
    }
  }
};

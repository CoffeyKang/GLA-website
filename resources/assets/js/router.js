import Home from './components/body/Home.vue';
import Contact from './components/body/Contact.vue';
import Special from './components/body/Special.vue';
import Catalog from './components/body/Catalog.vue';
import Products from './components/body/Products.vue';
import Ccbd from './components/body/Ccbd.vue';
import Product_list from './components/body/Product_list.vue';
import ItemDetails from './components/body/ItemDetails.vue';
import SearchResualt from './components/body/SearchResualt.vue';
import SearchList from './components/body/SearchList.vue';
import Wishlist from './components/body/Wishlist.vue';
import PageNotFound from './components/body/PageNotFound.vue';
import Login from './components/Login.vue';
import Dealer from './components/Dealer.vue';
import Register from './components/Register.vue';
import CustomerInfo from './components/CustomerInfo.vue';
import UserHome from './components/userAdmin/UserHome.vue';
import OrderHistory from './components/userAdmin/OrderHistory.vue';
import PendingOrder from './components/userAdmin/PendingOrder.vue';
import OneOrder from './components/userAdmin/OneOrder.vue';
import ChangeProfile from './components/userAdmin/ChangeProfile.vue';
import ChangePassword from './components/userAdmin/ChangePassword.vue';
import ShoppingCart from './components/body/shoppingCart.vue';
import Checkout from './components/body/Checkout.vue';
import DealerCheckout from './components/body/DealerCheckout.vue';
import ConfirmOrder from './components/body/ConfirmOrder.vue';
import Booklet from './components/body/parts/Booklet.vue';

// dealer admin
import ChangePass from './components/dealerAdmin/ChangePass.vue';
import OrderHistory_dealer from './components/dealerAdmin/OrderHistory.vue';
import PendingOrder_dealer from './components/dealerAdmin/PendingOrder.vue';
import OneOrder_dealer from './components/dealerAdmin/OneOrder.vue';
import dealHome from './components/dealerAdmin/dealerHome.vue';

export const routes = [
  {path: '/',component: Home,name: 'home'},
  {path: '/contact',component: Contact},
  {path: '/special',component: Special},
  {path: '/Catalog',component: Catalog},
  {path: '/allProducts',component: Products},
  {path: '/classicBody',component: Ccbd},
  {path: '/Product_list',component: Product_list, name: 'Pruduct_list'},
  {path: '/SearchResualt',component: SearchResualt, name: 'SearchResualt'},
  {path: '/Item/:id',component: ItemDetails, name: 'ItemDetails'},
  {path: '/wishlist',component: Wishlist, name: 'Wishlist'},
  {path: '/login',component: Login, name: 'Login'},
  {path: '/Dealer', component: Dealer, name: 'Dealer',
    children: [
      { path: '', component: dealHome, name: 'dealHome' },
      { path: 'HomePage', component: dealHome, name: 'dealHome' },
      { path: 'HistoryOrder', component: OrderHistory_dealer, name: 'OrderHistory_dealer' },
      { path: 'PendingOrder', component: PendingOrder_dealer, name: 'PendingOrder_dealer' },
      { path: 'oneOrder/:order_num', component: OneOrder_dealer, name: 'OneOrder_dealer' },
      { path: 'ChangePassword', component: ChangePass, name: 'ChangePass' }
    ]
  },
  {path: '/register', component: Register, name: 'Register'},
  {
    path: '/customerinfo', component: CustomerInfo, name: 'CustomerInfo',
    children: [
      { path: 'HomePage', component: UserHome, name: 'userHome' },
      { path: 'OrderHistory', component: OrderHistory, name: 'OrderHistory' },
      { path: 'PendingOrder', component: PendingOrder, name: 'PendingOrder' },
      { path: 'oneOrder/:order_num', component: OneOrder, name: 'OneOrder' },
      { path: 'ChangeProfile', component: ChangeProfile, name: 'ChangeProfile'},
      { path: 'ChangePassword', component: ChangePassword, name: 'ChangePassword' }
    ]
  },
  {path: '/SearchList',component: SearchList, name: 'SearchList'},
  {path: '/shoppingCart', component: ShoppingCart, name: 'ShoppingCart'},
  { path: '/checkout', component: Checkout, name: 'checkout' },
  { path: '/ConfirmOrder', component: ConfirmOrder, name: 'ConfirmOrder' },
  {
    path: '/dealer_checkout', component: DealerCheckout, name: 'DealerCheckout'
  },
  {
    path: '/booklet/:make', component: Booklet, name: 'Booklet'
  },
  {path: '*', component: PageNotFound }

];

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
import Register from './components/Register.vue';
import CustomerInfo from './components/CustomerInfo.vue';
import SetPromotion from './components/userAdmin/SetPromotion.vue';
import EditUser from './components/userAdmin/SetPromotion.vue';
import UserHome from './components/userAdmin/UserHome.vue';

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
  {path: '/register', component: Register, name: 'Register'},
  {path: '/customerinfo/:id', component: CustomerInfo, name: 'CustomerInfo',
    children: [
      { path: '', component: UserHome, name: 'userHome' },
      {path: 'setPromotion',component: SetPromotion, name: 'setPromotion'},
      {path: 'editUser',component: EditUser, name: 'editUser'}
    ]
  },
  {path: '/SearchList',component: SearchList, name: 'SearchList'},
  {path: '*', component: PageNotFound }

];

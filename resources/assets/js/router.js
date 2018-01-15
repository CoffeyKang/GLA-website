import Home from './components/body/Home.vue'
import Contact from './components/body/Contact.vue'
import Special from './components/body/Special.vue'
import Catalog from './components/body/Catalog.vue'
import Products from './components/body/Products.vue'
import Ccbd from './components/body/Ccbd.vue'
export const routes =[
	{path:'/',component:Home},
	{path:'/contact',component:Contact},
	{path:'/special',component:Special},
	{path:'/Catalog',component:Catalog},
	{path:'/allProducts',component:Products},
	{path:'/classicBody',component:Ccbd}
];
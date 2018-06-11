<template>
	<div>
		<div class='container-fuild'>
            <app-header></app-header>
        </div>
        <div class='container-fuild' id='body'>
            <router-view :key="$route.fullPath"></router-view>
        </div>
        <div class='container-fuild'>
            <app-footer></app-footer>
        </div>
        
	</div>
</template>

<script>
	/**
	 * components header and footer
	 */
	import Header from './components/Header.vue';
	import Footer from './components/Footer.vue';
	
	export default {
		data(){
			return {
				carts:[],
				storage:window.localStorage,
				items:[],
			}
		},
		components:{
			appHeader:Header,
			appFooter:Footer,
		},
		mounted(){
			
			// get items # from localstorage 
                for (let i = 0; i < this.storage.length; i++) {
                    this.items.push(this.storage.key(i));
                };
                // get item information 
				let data = this.items;
				
                this.$http.post('/api/getItems_carts',{data:this.items},[method=>"POST"]).then(response => {
                    this.carts = response.data.carts;
                    this.$store.commit('carts_number',this.carts.length);
                        
                }, response => {
                        // error 
                    console.log("error4");
				});
				
			// check if the use log in
			if (this.storage.getItem("userInfo")) {
				this.$store.commit('changeLoginStatus',true);
			}
		},
		watch: {
	    '$route' (to, from) {
			console.log('url changed');
			window.scrollTo(0,0);
			}
		},
		methods:{
			test(){
				console.log(1);
			}
		}
	}
</script>

<style scoped>
	#body{
		min-height: 700px;
	}
</style>
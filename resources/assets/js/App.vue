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
				usdPrice:this.$store.state.usdPrice,
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
				});

				var hei = $(window).height();
				if (window.innerWidth<768) {
					hei -= 130;
					$('#body').css('min-height',hei+'px');
				}else{
					hei -= 450;
					$('#body').css('min-height',hei+'px');
				}
				
				
			// check if the use log in
			

			//check is user info has been set
			
			
		},
		watch: {
	    '$route' (to, from) {
				window.scrollTo(0,0);
				$('.gla-nav').addClass('mobile_hide');
				
			}
		},
		methods:{
			test(){
				
			}
		},

		
	}
</script>

<style scoped>
	/* #body{
		min-height: 500px;
	} */
</style>
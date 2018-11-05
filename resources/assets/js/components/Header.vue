<template>
	<div class='container'>
		<div class="logo_top" id='page_top'>
			<div class='logo'>
				<div>
					<img src="images/header_logo.png" alt="Logo">
				</div>

				<div>
					<ul class='right-header'>
						<li @click='centerDialogVisible = true' ><span class="glyphicon glyphicon-search"></span></li>
						<router-link to='/login' tag='li' v-if="!loginStatus">Log In or Register</router-link>
						<li v-if="loginStatus" @click="logOut()"> Log Out</li>

						<li v-if="loginStatus" style='cursor:default'>Hello,{{name}}.</li>
						<li v-if="loginStatus" @click='customerInfo()'>My Account</li>
						<router-link to='/wishList' tag='li'>Wish List</router-link>
						<router-link to='/shoppingCart' tag='li'> 
							<el-badge :value="carts_total" class="item">
								<span class="glyphicon glyphicon-shopping-cart"></span>
							</el-badge>
						</router-link>
					</ul>
				</div>
				
			</div>

			<el-dialog
			  title=""
			  :visible.sync="centerDialogVisible"
			  width="50%"
			  center
			  >
			  	<app-search-layer @closeSearchLayer='centerDialogVisible = $event'></app-search-layer>

			</el-dialog>
		</div>
		<div class='gla-nav'>
			
			<div class='gla-nav-details'>
				<ul class='nav nav-pills black nav-justified'>
					<router-link to='/' tag='li' active-class='active ' exact><a>Home </a></router-link>
					<router-link to='/allProducts' tag='li' active-class='active' ><a>All Products</a></router-link>
					<router-link to='/catalog' tag='li' active-class='active'><a>Catalog</a></router-link>
					<router-link to='/classicBody' tag='li' active-class='active' ><a>Classic Body</a></router-link>
					<router-link to='/contact' tag='li' active-class='active' ><a>Contact</a></router-link>
					<router-link to='/special' tag='li' active-class='active' ><a><b>Special</b></a></router-link>
					<router-link to='/Dealer' tag='li' active-class='active' ><a>Dealers Area</a></router-link>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	import SearchLayer from './body/parts/SearchLayer.vue';
	export default{
		data(){
			return {
				centerDialogVisible:false,
				labelPosition: 'left',
				storage:window.localStorage,
				userID:0,
				usdPrice:this.$store.state.usdPrice,
				userInfo:{},
				username:'',
			}
		},
		components:{
			appSearchLayer:SearchLayer
		},
		methods:{
			logOut(){
				this.storage.clear();
				this.username='';
				this.$store.commit('changeLoginStatus',false);
				this.$store.commit('carts_number',0);
				this.$router.push('/');
			},
			customerInfo(){
				this.$router.push({path:'/CustomerInfo/HomePage'});
			}
		},
		mounted(){
			//get exchange rate
			this.$http.get('/api/exchangeRate').then(response=>{
				if (response.data.exchangeRate!=1) {
					
					this.$store.commit('exchange',response.data.exchangeRate);
				}else{
					this.$store.commit('exchange',1.35);
				}
			}), ()=>{
				this.$store.commit('exchange',1.35);
			};

			/**	call api to get exchange rate */
			if (this.storage.getItem("user")) {
				
				this.userID = JSON.parse(this.storage.getItem("user")).id;

				
					
			}else{
				console.log('not login');
			}

			if (this.storage.getItem("userInfo")) {
				
				if (JSON.parse(this.storage.getItem("userInfo")).m_country=='US'){
					this.$store.commit('usdPrice',true);
					this.usdPrice = this.$store.state.usdPrice;
					
				}else{
					this.$store.commit('usdPrice',false);
				}
			}
	
			//if is dealer
			
			
			
		},
		filters:{
			discount10(price) {
				return (price * 0.9).toFixed(2);
			}
		},
		
		computed:{
			
			carts_total(){
				return this.$store.state.carts_total;
			},
			loginStatus(){
				return this.$store.state.loginStatus;
			},

			name(){
				if (JSON.parse(this.storage.getItem("user")).level!=2) {
					this.userInfo = JSON.parse(this.storage.getItem("userInfo"));
					this.username = this.userInfo.m_forename + ' '+ this.userInfo.m_surname;
				}else{
					this.userInfo = JSON.parse(this.storage.getItem("userInfo"));
					this.username = this.userInfo.custno;
				}

				return this.username;
			}



		}
		

	}
</script>

<style scoped>
.gla-nav{
		background-color: yellow;
	}

.black .active a,
.black .active a:visited,
.black .active a:hover{
    background-color: black;
}
.nav-pills > .active > a, .nav-pills > .active > a:hover,.black .active a:visited {
    background-color: black;
}
li a{
	border-radius: 0;
	font-size: 24px;
	color: black;
	padding:10px 0;

}

.logo{
	padding: 20px 0;
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
	
}



.logo ul li{
	display: inline;
	padding-left: 10px;
	font-size: 20px;
	cursor:pointer;

}






	
	
	
	
	
</style>
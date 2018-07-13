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
						<router-link to='/login' tag='li' v-if="!loginStatus">Log In</router-link>
						<li v-if="loginStatus" @click="logOut()">Log Out</li>
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
			  title="I WANT TO FIND: "
			  :visible.sync="centerDialogVisible"
			  width="30%"
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
					<router-link to='/dealers' tag='li' active-class='active' ><a>Dealers Area</a></router-link>
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
			}
		},
		components:{
			appSearchLayer:SearchLayer
		},
		methods:{
			logOut(){
				this.storage.clear();
				this.$store.commit('changeLoginStatus',false);
				this.$store.commit('carts_number',0);
				this.$router.push('/');
			},
			customerInfo(){
				this.$router.push({path:'/CustomerInfo/HomePage'});
			}
		},
		mounted(){

			if (this.storage.getItem("user")) {
				
				this.userID = JSON.parse(this.storage.getItem("user")).id;
					
			}else{
				console.log('not login');
			}
			

		},
		
		computed:{
			
			carts_total(){
				return this.$store.state.carts_total;
			},
			loginStatus(){
				return this.$store.state.loginStatus;
			},



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
	font-size: 18px;
	color: black;
	padding:15px 0;

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
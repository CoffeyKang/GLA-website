<template>
	<div class='container'>
		<div class="logo_top" id='page_top'>
			<div class='logo'>
				<div >
					<img src="images/header_logo.png" alt="Logo" @click="$router.push('/')" style='cursor:pointer'>
				</div>

				<div>
					<ul class='right-header'>
						<li @click='centerDialogVisible = true' ><span class="glyphicon glyphicon-search"></span> | </li>
						<router-link to='/login' tag='li' v-if="!loginStatus">Log In or Register | </router-link>
						<li v-if="loginStatus" @click="logOut()"> Log Out  | </li>

						<li v-if="loginStatus" style='cursor:default'>Hello,{{name}}  | </li>
						<li v-if="loginStatus" @click='customerInfo()'>My Account  | </li>
						<router-link to='/wishList' tag='li'>Wish List  | </router-link>
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
					<router-link to='/special' tag='li' active-class='active' ><a><b>Specials</b></a></router-link>
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
			},

			

		},
		mounted(){
			// calculate the mileseconds to determin localstorage exipire or not
			var one_day=1000*60*60*24;
			var today = (new Date()).getTime();
			var timeStamp = this.storage.getItem('timeStamp')||today;
			var diff = today - timeStamp;
			diff = diff/one_day;

			if (diff>=7) {
				console.log('Localstorage expired');
				this.logOut();
			}else{
			}
			
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
			if (this.storage.getItem("user")&&this.storage.getItem("userInfo")) {
				
				this.userID = JSON.parse(this.storage.getItem("user")).id;

				this.$store.commit('changeLoginStatus',true);
					
			}else{
			}

			if (this.storage.getItem("userInfo")) {
				
				if (JSON.parse(this.storage.getItem("userInfo")).m_country=='US'){
					this.$store.commit('usdPrice',true);
					this.usdPrice = this.$store.state.usdPrice;
					
				}else{
					this.$store.commit('usdPrice',false);
				}
			}
			var accept = this.storage.getItem('accept');
			// cookie notifacation
			if (!accept) {
				this.$notify.info({
					title: 'Why We Use Cookies',
					dangerouslyUseHTMLString: true,
					message: "This site uses cookies to make your browsing experience more convenient and personal. Cookies store useful information on your computer to help us improve the efficiency and relevance of our site for you. In some cases, they are essential to making the site work properly. By accessing this site, you consent to the use of cookies. For more information, refer to GLA's privacy policy and cookie policy.<br> <b> <a style='cursor:pointer'>I understand</a></b>",
					position: 'bottom-right',
					duration: 10000,
					onClick:function(){
						window.localStorage.setItem('accept',true);
						this.close();
					},
					onClose:function(){
					}
				});	
			}else{

			}
			 
			
			
			
		},
		filters:{
			discount10(price) {
				return (price * 0.9).toFixed(2);
			}
		},
		
		computed:{
			
			
			loginStatus:{
				get:function() {
					return this.$store.state.loginStatus;
				},
				set:function(){

				},
			},

			carts_total(){
				return this.$store.state.carts_total;
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




@media screen and (min-width:1200px){
	.gla-nav{
		background-color:  #FFE512;
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
}
@media screen and (min-width:1000px) and (max-width: 1200px) {
	.gla-nav{
		background-color:  #FFE512;
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
		font-size: 20px;
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
		font-size: 18px;
		cursor:pointer;

	}
}

@media screen and (min-width:768px) and (max-width: 1000px){
	.gla-nav{
		background-color:  #FFE512;
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
		font-size: 14px;
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
		font-size: 14px;
		cursor:pointer;

	}
}


@media screen and (max-width:768px){
	.gla-nav{
		background-color:  #FFE512;
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
		font-size: 14px;
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
		font-size: 14px;
		cursor:pointer;

	}
}






	
	
	
	
	
</style>
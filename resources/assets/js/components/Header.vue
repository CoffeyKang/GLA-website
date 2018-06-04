<template>
	<div class='container'>
		<div class="logo_top" id='page_top'>
			<div class='logo'>
				<div>
					<img src="images/header_logo.png" alt="Logo">
				</div>
				
				<div>
					<ul>
						<li @click='centerDialogVisible = true' ><span class="glyphicon glyphicon-search"></span></li>
						<router-link to='/login' tag='li'>Log In</router-link>
						<router-link to='/wishList' tag='li'>Wish List</router-link>
						<router-link to='/shoppingCart' tag='li'> <span class="glyphicon glyphicon-shopping-cart"></span></router-link>
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
			}
		},
		components:{
			appSearchLayer:SearchLayer
		},
		methods:{
			
		},
		mounted(){
			
		},
		computed:{
			
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
	font-size: 14px;
	cursor:pointer;

}





	
	
	
	
	
</style>
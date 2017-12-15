<template>
	<div>
		<div class="logo_top">
			<div class='logo'>
				<div><img src="images/header_logo.png" alt="Logo"></div>
				
				<div>
					<ul>
						<li @click='centerDialogVisible = true' ><span class="glyphicon glyphicon-search"></span></li>
						<li>My Account</li>
						<li>Wish List</li>
						<li><span class="glyphicon glyphicon-shopping-cart"></span></li>
					</ul>
				</div>
			</div>

			<el-dialog
			  title="Search Bar"
			  :visible.sync="centerDialogVisible"
			  width="30%"
			  left

			  >
			  <el-form :label-position="labelPosition" label-width="80px">
				  <el-form-item label="Item">
				    <el-input ></el-input>
				  </el-form-item>
				  <el-form-item label="Make">
				    <el-input ></el-input>
				  </el-form-item>
				  <el-form-item label="Year">
				    <el-input ></el-input>
				  </el-form-item>
				</el-form>
			</el-dialog>
		</div>
		<div class='gla-nav'>
			
			<div class='gla-nav-details'>
				<ul class='nav nav-pills black nav-justified'>
					<router-link to='/' tag='li' active-class='active ' exact><a>Home</a></router-link>
					<router-link to='/allProducts' tag='li' active-class='active' ><a>All Products</a></router-link>
					<router-link to='/catalog' tag='li' active-class='active'><a>Catalog</a></router-link>
					<router-link to='/classicBody' tag='li' active-class='active' ><a>Classic Body</a></router-link>
					<router-link to='/dealers' tag='li' active-class='active' ><a>Dealers Area</a></router-link>
					<router-link to='/contact' tag='li' active-class='active' ><a>Contact</a></router-link>
					<router-link to='/special' tag='li' active-class='active' ><a>Special</a></router-link>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
import Search from './Search.vue';
	export default{
		data(){
			return {
				centerDialogVisible:false,
				labelPosition: 'left',
			}
		},
		components:{
			appSearch:Search,
		},
		methods:{
			
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
@media screen and ( min-width:1200px ){ 
	.gla-nav{
		display: flex;
		justify-content: center;
	}
	.gla-nav-details{
		width:1200px;
	}
	.logo_top{
		display: flex;
		justify-content: center;
	}
	.logo{
		width:1200px;
	}
}


	
	
	
	
	
</style>
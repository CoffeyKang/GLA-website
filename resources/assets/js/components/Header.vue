<template>
	<div class='gla-nav'>
		<div class='gla-nav-details'>
		<ul class='nav nav-pills nav-justified'>
			<router-link to='/' tag='li' active-class='active black_bg' exact><a>Home</a></router-link>
			<router-link to='/allProducts' tag='li' active-class='active' ><a>All Products</a></router-link>
			<router-link to='/catalog' tag='li' active-class='active' ><a>Catalog</a></router-link>
			<router-link to='/classicBody' tag='li' active-class='active' ><a>Classic Body</a></router-link>
			<router-link to='/dealers' tag='li' active-class='active' ><a>Dealers Area</a></router-link>
			<router-link to='/contact' tag='li' active-class='active' ><a>Contact</a></router-link>
			<router-link to='/special' tag='li' active-class='active' ><a>Special</a></router-link>

		  
		</ul>
		</div>
	</div>
</template>

<script>
	
</script>

<style scoped>
	li{
		padding-top: 0px;
		padding-bottom: 0px;
	}
	.gla-nav{
		background-color: yellow;
	}
	.gla-nav-details{
		padding:0 150px;
	}
	.active{
		background-color: black;
	}
	.black_bg{
		background-color:black;
	}
	
</style>
<template>
	<div>
		<div class="title container">
			<span>Products List {{ make }}</span>
		</div>
	
	<div class='container' id='car_makes'>
		
		<div class='car_make' v-for='item in lists'>
			<div class='item'>
				<div class="car_img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }">
				</div>

				<div class="car_make_name text-center">
					<h5>{{ item.item.toUpperCase() }}</h5>
				</div>

			</div>
			
		</div>
		

		
			
	</div>	

		
		
		
	</div>
		
</template>
<script>
	export default {
		data (){
			return {
				make:this.$route.query.make,
				lists:{},
				
				

				
				
			}
		},
		mounted(){
			this.$http.get('/api/product_list/'+ this.make).then(response => {
			    // get body data
			    this.lists = response.body;
			    console.log(this.lists);
			    console.log(this.lists.length);
			  }, response => {
			  	// error 
			    console.log("error");
			  });
		},
		methods:{
			
		}
	}
</script>
<style scoped>
	.item{
		margin: 0px 50px;
	}
	.title{
		margin-top: 10px;
		background-color: black;
		padding: 5px 20px;

	}
	.title span{
		font-size: 1.5em;
		color: white;
		font-weight: bold;
	}
	#car_makes{
		display: flex;
		justify-content: center;
		flex-wrap: wrap;
	}
	.car_make{
		margin-top: 30px;
		width: 220px;
		display: flex;
		flex-direction: column;

	}
	.car_make_name{

	}
	.car_img{
		padding: 30px;
		height: 200px;
		background-size: 100%;
		background-repeat: no-repeat;
		background-position: 50%;



	}
	
</style>
<template>
	<div class='container' id='car_makes'>
		<div class='car_make' v-for='make in makes'>
			<div >
				<div class="car_img" v-if='make.path!="default"'>
					<img :src="make.path" alt="123">
				</div>
				<div class="car_img" v-if=' make.path == "default"'>
					
					<img src="/images/makes/default.jpg" alt="2">
				</div>

				<div class="car_make_name text-center">
					<h3>{{ make.make.toUpperCase() }}</h3>
				</div>
			</div>
			
		</div>

		
		
		
	</div>
</template>
<script>
	export default {
		data (){
			return {
				makes : this.makes
				
			}
		},
		mounted(){
			this.$http.get('/api/makes').then(response => {
			    // get body data
			    this.makes = response.body;
			    console.log(this.makes);
			  }, response => {
			  	// error 
			    console.log("error");
			  });
		},
		methods:{
			m(){
				$(this).css('background-color','yellow');
				
			}
		}
	}
</script>
<style scoped>
img{
	width: 100%;
}
	#car_makes{
		display: flex;
		justify-content: center;
		flex-wrap: wrap;
	}
	.car_make{
		margin-top: 30px;
		width: 200px;
		display: flex;
		flex-direction: column;

	}
	.car_make_name{

	}
	.car_img{
		padding: 30px;
	}
	.blue{
		background-color: blue;
	}
</style>
<template>
	<div class='container' id='car_makes' v-loading='loading' element-loading-text='Loading ...'>
		<div class='car_make' v-for='make in makes' >
			<router-link :to="{
				name:'Pruduct_list', 
				query:{ make: make.make }
				}" tag='a'>
				<div class="car_img" v-if='make.path!="default"'>
					<img :src="make.path" alt="123">
				</div>
				<div class="car_img" v-if=' make.path == "default"'>
					
					<img src="/images/makes/default.jpg" alt="2">
				</div>

				<div class="car_make_name text-center">
					{{ make.make.toUpperCase().replace("_"," " ) }}
				</div>

			</router-link>
			
		</div>

		
		
		
	</div>
</template>
<script>
	export default {
		data (){
			return {
				makes : this.makes,
				loading:1,
				
			}
		},
		mounted(){
			this.$http.get('/api/makes').then(response => {
			    // get body data
			    this.makes = response.body;

			    this.loading = 0;
			    
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
a, a:hover{
	text-decoration:none;
}
a:hover{
	font-weight: bold;
}
	#car_makes{
		display: flex;
		justify-content: center;
		flex-wrap: wrap;
		margin-bottom: 60px;
	}
	.car_make{
		margin-top: 30px;
		width: 200px;
		display: flex;
		flex-direction: column;

	}
	.car_make_name{
		color: black;
		font-size: 1.4em;
	}
	.car_img{
		padding: 30px;
	}
	.blue{
		background-color: blue;
	}
</style>
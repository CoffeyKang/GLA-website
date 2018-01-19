<template>
	<div>
		<div class="title container">
			<span>Products List {{ make }}</span>
		</div>
	
	<div class='container' id='car_makes'>
		
		<div class='car_make' v-for='item in lists' >
			<router-link :to="{
				name:'ItemDetails',
				params:{id:item.item}
			}" >
				<div class='item'>
					<div class="car_img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }">
					</div>

					<div class="car_make_name text-center">
						<h6>{{item.year_from}} {{item.year_end}}</h6>
						<h5>{{ item.item.toUpperCase() }}</h5>
					</div>

				</div>
			</router-link>
			
		</div>
		<div class="container">
			
		
			<div class="container paginate_btn" >
				
				<!-- pre page -->
				<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
					Previous Page
				</button>
				<!-- next page -->
				<button class="btn btn default" @click="nextPage()" v-if="data.current_page!=data.last_page">
					Next Page
				</button>
				
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
				year:this.$route.query.year,
				lists:{},
				data:{},
				page:1,
				
			}
		},
		mounted(){
			this.$http.get('/api/searchResualt/',
				{params:
						{ 
							make:this.make,
							year:this.year,
						}
					}
				).then(response => {
			    // get body data
			    
			    this.data = response.body;
			    this.lists = response.body.data;
			    this.page = this.data.current_page;
			    console.log(this.lists);
			  }, response => {
			  	// error 
			    console.log("error");
			  });
		},
		created(){
			console.log(1);
		},
		computed:{
			
		},
		methods:{
			nextPage(){
				this.page +=1;
				this.$http.get('/api/searchResualt/',
				{params:
						{ 
							make:this.search.make,
							year:this.search.year,
						}
					}
				).then(response => {
			    // get body data
			    this.data = response.body;
			    this.lists = response.body.data;
			    this.page = this.data.current_page;

			  }, response => {
			  	// error 
			    console.log("error");
			  });
			},
			prePage(){
				this.page -=1;
				this.$http.get('/api/searchResualt/',
				{params:
						{ 
							make:this.search.make,
							year:this.search.year,
						}
					}
				)	.then(response => {
			    // get body data
			    this.data = response.body;
			    this.lists = response.body.data;
			    this.page = this.data.current_page;

			  }, response => {
			  	// error 
			    console.log("error");
			  });
			}
		},
		watch:{
			
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
	.paginate_btn{
		display: flex;
		justify-content: space-between;
	}
	
</style>
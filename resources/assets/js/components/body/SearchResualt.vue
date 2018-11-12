<template>
	<div>
		<div class=" container">
			<div class="title">
			<span>Products List {{ make.toUpperCase() }}</span>
			</div>
		</div>
	
	<div class='container' id='car_makes'>
		
		<div class='car_make' v-for='item in lists' >
				<div class='item'>
					<div class="car_img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }">
					</div>
					
					<div class="car_make_name text-center">
						<span>{{ item.item.toUpperCase() }}</span>
					</div>
					<div class="car_make_name text-center">
						<span>Year Fit: {{ item.year_from }} - {{ item.year_end }}</span>
					</div>

					<div class="car_make_name text-center">
						<span class='price_label'>Sale Price: <b class='price'>$ {{ item.pricel.toFixed(2) }}</b> </span>
					</div>

					<div class="car_make_name text-center description">
						<span>{{showLimitedWords(item.descrip,35)  }}</span>
					</div>

					<div class='add_details' @click='goToItem(item.item)'>
						<button class="btn btn-primary">
							Details
						</button>
						<a href='#' class='add_to_cart'>
							Add To Cart 
						</a>
					</div>
				</div>
			
			
		</div>
		<div class="container">
			
		
			<div class="container paginate_btn" >
				
				<div class="text-left">
					{{data.total}}   Products found, Page {{page}} of {{data.last_page}}
				</div>
				<div>
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

		
		
		
	</div>
		
</template>
<script>
	export default{
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
			    
			  }, response => {
			  	// error 
			     
			  });
		},
		created(){
		},
		computed:{
			
		},
		methods:{
			nextPage(){
				this.page +=1;
				this.$http.get('/api/searchResualt/',
				{params:
						{ 
							make:this.make,
							year:this.year,
							page:this.page,

						}
					}
				).then(response => {
			    // get body data
			    this.data = response.body;
			    this.lists = response.body.data;
			    this.page = this.data.current_page;
			    

			  }, response => {
			  	// error 
			     
			  });
			},


			
			prePage(){
				this.page -=1;
				this.$http.get('/api/searchResualt/',
				{params:
						{ 
							make:this.make,
							year:this.year,
							page:this.page,
						}
					}
				).then(response => {
			    // get body data
			    this.data = response.body;
			    this.lists = response.body.data;
			    this.page = this.data.current_page;

			  }, response => {
			  	// error 
			     
			  });
			},
			showLimitedWords:function(str,num){
				
				if (str.length <= num) {
					return str;
				}else{
					str = str.slice(0,num)+'...';
					return str;
				}
				
			},
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
		width: 280px;
		display: flex;
		flex-direction: column;

	}
	.car_make_name{
		margin-top: 10px;
	}
	.car_img{
		padding: 30px;
		height: 200px;
		background-size: 100%;
		background-repeat: no-repeat;
		background-position: 50%;



	}
	.paginate_btn{
		margin-top: 20px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20px;
	}
	.paginate_btn .btn{
		min-width: 115px;
	}
	.price_label{color: red;}
	.price{
		color:#800000;
	}
	.add_details{
		display: flex;
		justify-content: space-between;
		padding: 10px;
	}
	.add_to_cart{
		display: flex;
		align-items: flex-end;
	}
	.description{
		min-height: 70px;
	}
	
</style>
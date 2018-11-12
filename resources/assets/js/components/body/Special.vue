<template>
	<div v-loading='loading'  
		 element-loading-text="Loading ..."
		  >
		<div class="container">
			<div class="title">
				<span>On Sale products</span>
			</div>
		</div>
		<div class='container' id='car_makes'>
		
			<div class='car_make' v-for='item in lists' :key='item.item'>
			
				<div class='item'>
					<div class="car_img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }" @click='goToItem(item.item)'>
					</div>
					
					<div class="car_make_name text-center">
						<span>{{ item.item.toUpperCase() }}</span>
					</div>
					<div class="car_make_name text-center">
						<span>Year Fit: {{ item.year_from }} - {{ item.year_end }}</span>
					</div>

					<div class="car_make_name text-center" v-if="disc">
						<span class='price_label'>CAD: <b class='price'>  $<span style='text-decoration:line-through' >{{item.pricel.toFixed(2) }}</span> ${{ item.pricel | discount10 }}</b><br>
							<span v-if='usdPrice' class='usdPrice'>USD  $<span style='text-decoration:line-through' >{{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span> ${{ ((item.pricel)/$store.state.exchange) | discount10 }}</span>
						</span>
					</div>

					<div class="car_make_name text-center" v-if="!disc">
						<span class='price_label'>CAD: <b class='price'>  {{item.pricel.toFixed(2) }}</b><br>
							<span v-if='usdPrice' class='usdPrice'>USD  ${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span>
						</span>
					</div>

					<div class="car_make_name text-center description">
						<span>{{showLimitedWords(item.descrip,35)  }}</span>
					</div>

					<div class='add_details' >
						<button class="btn btn-primary" @click='goToItem(item.item)'>
							Details
						</button>
						<button class='add_to_cart btn btn-link' @click='addToCart_common_list(item)'>
							Add To Cart  
						</button>
					</div>
				</div>
			</div>
			<div class="container paginate_btn alert">
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
		
</template>
<script>

	export default {
		data (){
			return {
				lists:{},
				data:{},
				page:1,
				loading:1,
				disc:true,
				// usdPrice:this.$store.state.usdPrice,
			}
		},
		mounted(){
			/**	get special list */
			this.$http.get('/api/special/'+this.page).then(response => {
			    this.lists = response.data.special.data;
				this.data = response.data.special;
				this.lists.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});	
			    this.page = this.data.current_page;
				window.scrollTo(0,0);
			    // finish ladding screen
			    this.loading = 0;
			  }, response => {
			  	// error 
			     
			  });



			  /**	 check if it is dealer */

			  if (this.ifDealer()) {
				  this.disc = false;
			  }

			 
		},
		methods:{
			nextPage(){
				this.page +=1;
				this.$http.get('/api/special/'+this.page).then(response => {
			    this.lists = response.data.special.data;
				this.data = response.data.special;
				this.lists.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});	
							window.scrollTo(0,0);
			    this.page = this.data.current_page;
			    // finish ladding screen
			    this.loading = 0;
			  }, response => {
			  	// error 
			     
			  });
			},
			prePage(){
				this.page -=1;
				this.$http.get('/api/special/'+this.page).then(response => {
			    this.lists = response.data.special.data;
				this.data = response.data.special;
				this.lists.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});	
			    this.page = this.data.current_page;
window.scrollTo(0,0);
			    // finish ladding screen
			    this.loading = 0;
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
			goToItem($item){
				this.$router.push({
					name:'ItemDetails',
					params:{
						id:$item,
					}
				});
			},
			

			addToCart_common_list(item) {
				if (item.onhand < 1) {
					this.$alert('Out of stock', 'Warning', {
					confirmButtonText: 'OK'
					});
				} else {
					if (window.localStorage.getItem(item.item)) {
					var qty = parseInt(window.localStorage.getItem(item.item)) + 1;
					window.localStorage.setItem(item.item, qty);
					} else {
					window.localStorage.setItem(item.item, 1);

					var newNumber = this.carts_number + 1;

					this.$store.commit('carts_number', newNumber);
					}
					const h = this.$createElement;
					this.$notify({
						title: 'Succsesfully.',
						message: h('b', { style: 'color: teal'}, 'The item has been already put into shopping cart')
					});
				}
			},
			
		},
		computed:{
			usdPrice(){
				return	this.$store.state.usdPrice;
			}
		},
		filters:{
			discount10(price) {
				return (price * 0.9).toFixed(2);
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
	.shoppingCart{
		color: yellow;
		cursor: pointer;
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
		cursor: pointer;



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
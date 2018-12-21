<template>
	<div v-loading='loading'  
		 element-loading-text="Loading ..."
		  >
		<div class="container">
			<div class="title">
				<span>On Sale Products</span>
			</div>
			<div class='searchBar'>
				<search-special :search='search' v-on:updateSearch = "updateSearch($event)"
				v-on:resetSearch = "resetSearch($event)"></search-special>
			</div>
		</div>
		<div class="container paginate_btn alert mobile_no" v-if="lists.length>=1"> 
				<div class='col-xs-4 text-right'>
					<!-- pre page -->
					<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
						Previous Page
					</button>
				</div>
				<div class='col-xs-4 text-center'>
					{{data.total}}  Products found, Page 
					<el-select v-model="page" placeholder="Change Page" style='width:80px;' @change='toPage(page)'>
						<el-option
							v-for="p in pages"
							:key="p"
							:label="p"
							:value="p">
						</el-option>
					</el-select> / of {{data.last_page}}
				</div>
				<div class='col-xs-4'>
					<!-- next page -->
					<button class="btn btn default" @click="nextPage()" v-if="data.current_page!=data.last_page">
						Next Page
					</button>
				</div>
		</div>

		<div class="container paginate_btn alert mobile_show ">
			<div class="container" style='display:flex; justify-content:space-around'>
			
				<div class='text-right mobile_show col-xs-3'>
					<!-- pre page -->
					<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
						Previous
					</button>
				</div>
				<div class='text-center mobile_show col-xs-3'>
					<el-select v-model="page" placeholder="Change Page" style='width:80px;' @change='toPage(page)'>
						<el-option
							v-for="p in pages"
							:key="p"
							:label="p"
							:value="p">
						</el-option>
					</el-select>
				</div>
				<div class='text-left mobile_show col-xs-3'>
					<button class="btn btn-default" @click="nextPage()" v-if="data.current_page!=data.last_page">
						Next Page
					</button>
				</div>
			</div>
		</div>
		
		<div class='container' id='car_makes'>
		
			<div class='car_make' v-for='item in lists' :key='item.item' v-if="lists.length>=1">
			
				<div class='item'>
					<div class="car_img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }" @click='goToItem(item.item)'>
					</div>
					
					<div class="car_make_name text-center">
						<span>{{ item.item.toUpperCase() }}</span>
					</div>
					<div class="car_make_name text-center">
						<span>Year Fit: {{ item.year_from }} - {{ item.year_end }}</span>
					</div>

					<div class="car_make_name text-center">
						<span>MAKE: {{ item.make }}</span>
					</div>

					<div class="car_make_name text-center" v-if="disc">
						<span class='price_label'>CAD: <b class='price'>  <span style='text-decoration:line-through; color:#800000' >${{item.pricel.toFixed(2) }}</span> ${{ item.pricel | discount10 }}</b><br>
							<span v-if='usdPrice' class='usdPrice'>USD  <span style='text-decoration:line-through; color:#800000' >${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span> ${{ ((item.pricel)/$store.state.exchange) | discount10 }}</span>
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
						<a class='add_to_cart btn' @click='addToCart_common_list(item)'>
							Add To Cart  
						</a>
					</div>
				</div>
			</div>

			<div v-if='lists.length<1' class='alert alert-warning container' style='margin-top:30px;margin-bottom:100px'>
				<b>Your search did not match any special products.<br></b>
				Try something like<br>
				<ul>
					<li>Using more general terms</li>
					<li>Checking your spelling</li>
				</ul>
			</div>
		<div class="container paginate_btn alert mobile_no" v-if="lists.length>=1">
			<div class='col-xs-4 text-right'>
				<!-- pre page -->
				<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
					Previous Page
				</button>
			</div>
			<div class='col-xs-4 text-center'>
				{{data.total}}  Products found, Page 
				<el-select v-model="page" placeholder="Change Page" style='width:80px;' @change='toPage(page)'>
					<el-option
						v-for="p in pages"
						:key="p"
						:label="p"
						:value="p">
					</el-option>
				</el-select> / of {{data.last_page}}
			</div>
			<div class='col-xs-4'>
				<!-- next page -->
				<button class="btn btn default" @click="nextPage()" v-if="data.current_page!=data.last_page">
					Next Page
				</button>
			</div>
		</div>

		<div class="container paginate_btn alert mobile_show ">
			<div class='container' style='display:flex; justify-content:space-around'>
				<div class='mobile_show col-xs-3'>
					<!-- pre page -->
					<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
						Previous
					</button>
				</div>
				<div class='text-center mobile_show col-xs-3'>
					<el-select v-model="page" placeholder="Change Page" style='width:80px;' @change='toPage(page)'>
						<el-option
							v-for="p in pages"
							:key="p"
							:label="p"
							:value="p">
						</el-option>
					</el-select>
				</div>
				<div class='text-left mobile_show col-xs-3'>
					<button class="btn btn-default" @click="nextPage()" v-if="data.current_page!=data.last_page">
						Next Page
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
		
</template>
<script>
	import SearchSpecial from './parts/SearchSpecial.vue';
	export default {
		data (){
			return {
				search:{},
				lists:{},
				data:{},
				page:1,
				loading:1,
				disc:true,
				// usdPrice:this.$store.state.usdPrice,
			}
		},
		components:{
			SearchSpecial,
		},
		mounted(){
			/**	get special list */
			this.$http.post('/api/searchSpecial',{
					item:this.search.item, 
					make:this.search.make,
					year:this.search.year,
					desc:this.search.desc,
					page:this.page,
				}).then(response => {
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
				this.loading=1,
				this.page +=1;
				this.$http.post('/api/searchSpecial',{
					item:this.search.item, 
					make:this.search.make,
					year:this.search.year,
					desc:this.search.desc,
					page:this.page,
				}).then(response => {
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
				this.loading=1,
				this.page -=1;
				this.$http.post('/api/searchSpecial',{
					item:this.search.item, 
					make:this.search.make,
					year:this.search.year,
					desc:this.search.desc,
					page:this.page,
				}).then(response => {
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

			toPage(page){
				this.loading=1,
				this.page =page;
				
				this.$http.post('/api/searchSpecial',{
					item:this.search.item, 
					make:this.search.make,
					year:this.search.year,
					desc:this.search.desc,
					page:this.page,
				}).then(response => {
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
						message: h('b', { style: 'color: teal'}, 'Item successfully added to cart')
					});
				}
			},
			resetSearch(){
				this.search ={};
			},

			updateSearch(value){
				this.loading=1,
				this.$http.post('/api/searchNewItem',{
					item:value.item, 
					make:value.make,
					year:value.year,
					desc:value.desc,
					page:1
				}).then(response => {
			    this.lists = response.data.special.data;
				this.data = response.data.special;
				this.lists.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});	
			    this.page = this.data.current_page;
				window.scrollTo(0,0);
				this.loading=0,
			    // finish ladding screen
			    this.loading = 0;
			  }, response => {
			  	// error 
			     
			  });
			},
			
		},
		computed:{
			usdPrice(){
				return	this.$store.state.usdPrice;
			},
			pages(){
				var pages = [];
				for (let index = 1; index <= this.data.last_page; index++) {
					pages.push(index);
					
				}
				return pages;
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
	.searchBar{
        background-color: black;
        padding: 10px 0;
    }
	.item{
		margin: 0px 50px;
	}
	.shoppingCart{
		color:  #FFE512;
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
		font-size: 16px;

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
		color:red;
	}
	.add_details{
		display: flex;
		justify-content: space-between;
		padding: 10px;
	}
	.add_to_cart{
		margin-left: 10px;
		display: flex;
		align-items: flex-end;
	}

	.add_to_cart:hover{
		border: 1px solid #2a88bd;
	}
	.description{
		min-height: 70px;
	}
	.mobile_show{
		display: none;
	}

	@media screen and (max-width: 768px) {
		.mobile_no{
			display: none;


		}
		.mobile_show{
			display: block;
		}

		.paginate_btn .btn{
			min-width: 50px;
		}
	}	

	

	
</style>
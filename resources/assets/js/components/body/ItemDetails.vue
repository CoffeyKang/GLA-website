<template>
	<div class='container ItemDetails'>
		<div class="nav" id='top'>
			<span @click='backToSearch()' class='backToSearch' v-if="search">RETURN TO SEARCH RESULT </span>
		</div>
		<div class="item" v-if='showItem'>
			<div class="itemImages col-xs-12 col-sm-6 mobile_no" :style="{ backgroundImage: 'url(' + item.img_path + ')' }" @click="dialogVisible = true"> 
			</div>

			<div class="itemImages col-xs-12 col-sm-6 mobile_show" :style="{ backgroundImage: 'url(' + item.img_path + ')' }"> 
			</div>
			<div class="words col-xs-12 col-sm-offset-1 col-sm-5">
				<div class="descrip">
					<span style=' text-transform: uppercase'>{{ item.descrip }}</span>
				</div>
				<div class="details text-left">
					<li><span class='column_name'>Item Number:</span> <b >{{item.item}}</b></li>
					<li><span class='column_name'>Year Fit: </span><b>{{item.year_from}} -- {{item.year_end}}</b></li>
					<li><span class='column_name'>Compatible Make: </span><b v-for="item_make in item_makes" :key="item_make.row_id"> {{item_make.make}} &nbsp;</b></li>
				</div>
				<div class="priceDiv">
					
					<div class="price" v-if="item.onsale&&disc">
						CAD <span style='text-decoration:line-through; color:#800000'>$ {{item.pricel.toFixed(2) }}</span> ${{ item.pricel | discount10 }}<br> 
						<span v-if='usdPrice' class='usdPrice'>USD <span style='text-decoration:line-through ; color:#800000'> ${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span> ${{ ((item.pricel)/$store.state.exchange) | discount10 }}</span>
					</div>

					<div class="price" v-if="!item.onsale || !disc">
						CAD ${{ item.pricel.toFixed(2) }}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span>
					</div>
					<div class="action">
						<div class='action_left'>
							<div class="inStock">In-Stock: <span v-if="item.onhand>0">{{item.onhand}}</span> <span v-if="item.onhand==0">Not In Stock</span></div>
							<div class="quantity row">
								<div class="col-sm-4" style='font-size:20px;'>
									Quantity:
								</div>
								<div class="col-sm-5">
									<el-select v-model="quantity" size='mini' popper-class='text-center' >
										<el-option
											v-for="a in item.onhand"
											:key="a.item"
											:label="a"
											:value="a">
										</el-option>
									</el-select>
								</div>
								<div class="col-sm-3">
									 
								</div>
								
							</div>
							<div class="wish" @click="addToWishlist(item.item)">
								Add To Wishlist &nbsp;<span class="glyphicon glyphicon-heart-empty"></span>
							</div>
						</div>
						<div class="action_right">
							<button class='btn btn-primary addToCart' id='addToCart' @click='addToCart_common(item)'>Add To Cart</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="related contaner">
			RELATED PRODUCTS
		</div>
		<div class="related_products container">
			<div v-for='r in related' :key='r.item'>
				<div class='related_item'>
					<div class="car_img" :style="{ backgroundImage: 'url(' + r.img_path + ')' }" @click="goTo(r.item)"> 
					</div>
					<div class="related_details text-left">
						<li><span class='related_colum'>Item Number: #{{r.item}}</span> </li>
						<li><b>{{r.descrip}}</b></li>
						<li><span class='related_colum'>Year Fit: {{r.year_from}} -- {{r.year_end}}</span></li>
						<li><span class='related_colum all_make'>Make: {{r.all_makes}}</span></li>
						<div class="realted_priceDiv"  v-if="r.onhand > r.orderpt && disc">
							CAD <span style='text-decoration:line-through; color:#800000'> ${{r.pricel.toFixed(2) }}</span> ${{r.pricel | discount10}}<br>
							<span v-if='usdPrice' class='usdPrice'>USD <span style='text-decoration:line-through; color:#800000'>${{ ((r.pricel)/$store.state.exchange).toFixed(2) }}</span> ${{ ((r.pricel)/$store.state.exchange) | discount10 }}</span>
						</div>

						<div class="realted_priceDiv"  v-if="r.onhand <= r.orderpt || !disc">
							CAD ${{r.pricel.toFixed(2)}}<br>
							<span v-if='usdPrice' class='usdPrice'>USD ${{ ((r.pricel)/$store.state.exchange).toFixed(2) }}</span>
						</div>
						
						<button class="btn btn-primary" @click="goTo(r.item)">
							Details
						</button>
					</div>
				</div>
			</div>
		</div>
		
		<el-dialog
			:visible.sync="dialogVisible"
			custom-class='bigpic'
			width=55%
			>
			<span style='margin:auto;text-align:center'
			><img :src="item.big" alt="" style='width:100% '></span>
			
		</el-dialog>

	</div>
</template>
<script>
	
	export default {
		data(){
			return {
				 dialogVisible: false,
				id:this.$route.params.id,
				item:{},
				related:{},
				color:"red",
				showItem :false,
				quantity:1,
				disc:true,

			}
		},
		created(){
			
		},
		mounted(){
			this.$http.get('/api/item/'+ this.id).then(response => {
			    // get body data
			    
				this.item = response.body.singleItem;

				this.item.pricel = this.Dealerprice(this.item);
				
				this.item_makes = response.body.item_makes;

				

			    this.showItem = true;
				
			  }, response => {
			  	// error 
			  });

			// get related item
			this.$http.get('/api/related/'+ this.id).then(response => {
				// get body data
				
				this.related = response.data;
				this.related.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});
			  }, response => {
			  	// error 
			  });
	
			this.viewed(this.id);

			if (this.ifDealer()) {
				this.disc= false;
			}else{
				this.disc=true;
			}

			
		},
		methods:{
			goTo(item){
				this.$http.get('/api/item/'+ item).then(response => {
			    // get body data
				this.item = response.body;
				this.$router.push({name:'ItemDetails', params:{id:item}});
			    window.scrollTo(0,0);
			  }, response => {
			  	// error 
			  });

			},

			// back to search result
			backToSearch(){
				this.$router.push({name:'SearchList',query:{
					item:this.getItem,
					make:this.getMake,
					year:this.getYear,
					desc:this.getDesc,
				}});
			},

			// addToCart
			addToCart(item){ 
				if (this.item.onhand<1) {
					this.$alert('Out of stock', 'Warning', {
						confirmButtonText: 'OK',
					});
				}else{
					if (window.localStorage.getItem(item)) {
						var qty = parseInt(window.localStorage.getItem(item)) + this.quantity;
						window.localStorage.setItem(item,qty);
					}else{
						window.localStorage.setItem(item,this.quantity);
						var newNumber = this.carts_number+1;
						
						this.$store.commit('carts_number',newNumber);

					}
					
					const h = this.$createElement;
					this.$notify({
						title: 'Succsesfully.',
						message: h('b', { style: 'color: teal'}, 'The item has been already put into shopping cart')
					});
				}
			},
			
			
		},

		filters:{
			discount10(price) {
				return (price * 0.9).toFixed(2);
			}
		},
		computed:{
			getItem(){
				return this.$store.state.search.item;
			},
			getMake(){
				return this.$store.state.search.make;
			},
			getDesc(){
				return this.$store.state.search.desc;
			},
			getYear(){
				return this.$store.state.search.year;
			},
			carts_number(){
				return this.$store.state.carts_total;
			},
			usdPrice(){
				return	this.$store.state.usdPrice;
			},

			search(){
				if (
					this.$store.state.search.item=="thisIsItem"&&
					this.$store.state.search.desc=="zheshidewc"&&
					this.$store.state.search.make=="make"
					) {
					return false;
				}else{
					return true;
				}
			}

		}

	}



</script>
<style scoped>
.mobile_show{
	display: none;
}
	.backToSearch{
		font-size: 12px;
		cursor: pointer;
	}
	.ItemDetails{
		display: flex;
		flex-direction: column;
	}
	.item{
		display: flex;
		justify-content: space-between;
	}
	.itemImages{
		
		border-radius: 12px 12px 0 0;
	    background-position: center;
	    background-repeat: no-repeat;
	    background-size: contain;
	    height: 400px;
		cursor: zoom-in;

		
	}
	
	.words{
		display: flex;
		flex-direction: column;
	}
	li{
		list-style-type: none;
		font-size: 1em;
		padding:2px 0px;
	}
	.descrip, .details, .priceDiv{
		padding-bottom: 20px;
		padding-top: 20px;
		border-bottom: 1px black solid;
		
	}
	.priceDiv{
		border-bottom: none;
		padding-bottom:50px;
	}
	.details{
		font-size: 20px;
	}
	.descrip span{
		font-size: 20px;
		line-height: 30px;
		font-weight: bold;
	}
	.price{
		font-size: 2.6em;
		font-weight: bold;
		color: red;
	}
	
	.action{
		display: flex;
		justify-content: space-between;
	}
	.inStock{
		color: green;
		font-size: 20px;
		padding-bottom: 5px;
	}
	.wish{
		color: red;
		font-size: 1.4em;
		cursor: pointer;
	}
	.addToCart{
		font-size: 1.6em;

	}
	.nav{
		font-size: 1.4em;
		padding: 20px 0;
	}
	.related{
		background-color:  #FFE512;
		font-size: 1.6em;
		padding: 10px 20px;
		font-weight: bold;
	}
	.related_products{
		display: flex;
		justify-content:space-between;
		margin-bottom: 25px;
	}

	.car_img{
		height: 200px;
		background-size: 100%;
		background-repeat: no-repeat;
		background-position: 50%;
		cursor: pointer;

	}
	
	.related_item{
		width: 260px;
		padding: 20px;
		
	}
	.related_details li{
		padding: 0;
		white-space: nowrap;
	  	overflow: hidden;
	  	text-overflow: ellipsis;
	  	max-width: 220px;

	}
	.realted_priceDiv{
		color: red;
		font-size: 1.2em;
		font-weight: bold;
	}

	.action_right{
		display: flex;
		align-items: flex-end;
	}

	@media screen and (max-width: 768px) {
		.related_products{
			display: flex;
			flex-direction: column;
			justify-content:space-between;
			margin-bottom: 25px;
		}
		.item{
			display: flex;
			flex-direction: column;
			justify-content: space-between;
		}
		.mobile_show{
			display: inline;
		
		}
		.mobile_no{
			display: none;
		}
		
	}

</style>
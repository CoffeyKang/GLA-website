<template>
	<div class='container ItemDetails'>
		<div class="nav" id='top'>
			HOME/FIREBIRD/PARTS
		</div>
		<div class="item" v-if='showItem'>
			<div class="itemImages col-xs-6" :style="{ backgroundImage: 'url(' + item.img_path + ')' }"> 

			</div>
			<div class="words col-xs-offset-1 col-xs-5">
				<div class="descrip">
					<span style=' text-transform: uppercase'>{{ item.descrip }}</span>
				</div>
				<div class="details text-left">
					<li><span class='column_name'>Item Number:</span> <b>{{item.item}}</b></li>
					<li><span class='column_name'>Year Fit: </span><b>{{item.year_from}} -- {{item.year_end}}</b></li>
					<li><span class='column_name'>Make: </span><b>{{item.make}}</b></li>
				</div>
				<div class="priceDiv">
					<div class="price">
						$ {{ item.pricel.toFixed(2) }}
					</div>
					<div class="action">
						<div class='action_left'>
							<div class="inStock">In-Stock: {{item.onhand}}</div>
							<div class="quantity row">
								<div class="col-xs-3">
									Quantity:
								</div>
								<div class="col-xs-6">
									<el-select v-model="quantity" size='mini' popper-class='text-center'>
										<el-option
											v-for="a in item.onhand"
											:key="a.item"
											:label="a"
											:value="a">
										</el-option>
									</el-select>
								</div>
								<div class="col-xs-3">
									 
								</div>
								
							</div>
							<div class="wish">
								Add To Wishlist &nbsp;<span class="glyphicon glyphicon-heart-empty"></span>
							</div>
						</div>
						<div class="action_right">
							<button class='btn btn-primary addToCart'>Add To Cart</button>
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
					<div class="car_img" :style="{ backgroundImage: 'url(' + r.img_path + ')' }">
					</div>

					<div class="related_details text-left">
						<li><span class='related_colum'>Item Number: #{{r.item}}</span> </li>
						<li><b>{{r.descrip}}</b></li>
						<li><span class='related_colum'>Year Fit: {{r.year_from}} -- {{r.year_end}}</span></li>
						<li><span class='related_colum'>Make: {{r.make}}</span></li>
						<div class="realted_priceDiv">
							${{r.pricel.toFixed(2)}}
						</div>
						
						<button class="btn btn-primary" @click="goTo(r.item)">
							Details
						</button>
					</div>
				</div>
			</div>
		</div>
		
		</div>

	</div>
</template>
<script>
	
	export default {
		data(){
			return {
				id:this.$route.params.id,
				item:{},
				related:{},
				color:"red",
				showItem :false,
				quantity:1,

			}
		},
		created(){

			console.log(this.$route.params.id);
		},
		mounted(){
			this.$http.get('/api/item/'+ this.id).then(response => {
			    // get body data
			    
			    this.item = response.body;

			    console.log(this.item.pricel);

			    this.showItem = true;



			  }, response => {
			  	// error 
			    console.log("error");
			  });

			// get related item
			this.$http.get('/api/related/'+ this.id).then(response => {
			    // get body data
			    
			    this.related = response.body;
			    console.log(this.related);

			  }, response => {
			  	// error 
			    console.log("error");
			  });
			

		},
		methods:{
			goTo($item){
				this.$http.get('/api/item/'+ $item).then(response => {
			    // get body data
			    this.item = response.body;
			    window.scrollTo(0,0);
			  }, response => {
			  	// error 
			    console.log("error");
			  });

			// get related item
			this.$http.get('/api/related/'+ $item).then(response => {
			    // get body data
			    this.related = response.body;
			    console.log(this.related);

			  }, response => {
			  	// error 
			    console.log("error");
			  });

			},
			
		}

	}



</script>
<style scoped>
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
	    background-position: 50%;
	    background-repeat: no-repeat;
	    background-size: 100%;
	    height: 600px;

		
	}
	
	.words{
		display: flex;
		flex-direction: column;
		
		padding: 50px;
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
	.descrip span{
		font-size: 1.8em;
		line-height: 30px;
		font-weight: bold;
	}
	.price{
		font-size: 3em;
		font-weight: bold;
		color: red;
	}
	.column_name{

	}
	.action{
		display: flex;
		justify-content: space-between;
	}
	.inStock{
		color: green;
		font-size: 1.2em;
		padding-bottom: 5px;
	}
	.wish{
		color: red;
		font-size: 1.4em;
	}
	.addToCart{
		font-size: 1.6em;

	}
	.nav{
		font-size: 1.4em;
		padding: 20px 0;
	}
	.related{
		background-color: yellow;
		font-size: 1.6em;
		padding: 10px 20px;
		font-weight: bold;
	}
	.related_products{
		display: flex;
		justify-content:space-between;
	}

	.car_img{
		height: 200px;
		background-size: 100%;
		background-repeat: no-repeat;
		background-position: 50%;

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
		font-size: 1.8em;
		font-weight: bold;
	}

	.action_right{
		display: flex;
		align-items: flex-end;
	}



</style>
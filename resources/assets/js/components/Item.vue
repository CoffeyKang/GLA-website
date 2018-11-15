<template>
	<div class='item'>
		
		<div class="img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }" @click='goToItem(item.item)'>	
			
		</div>
		<div class="words">
			
			<small>Product No: {{ item.item}}</small>
			
			<span class='description'>{{ item.descipt}}</span>
			
			<small>Year Fit: {{ item.year_begin}} -- {{item.year_end}}</small>
			
			<small>Make: {{ item.make}} </small>
			
			<span class='price' v-if="disc">
				<span class='price_label'>CAD: <b class='price'>  $<span style='text-decoration:line-through' >{{item.pricel.toFixed(2) }}</span> ${{ item.pricel | discount10 }}</b><br>
							<span v-if='usdPrice' class='usdPrice'>USD  $<span style='text-decoration:line-through;' >{{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span> ${{ ((item.pricel)/$store.state.exchange) | discount10 }}</span>
						</span>
				<!-- CAD ${{ item.pricel.toFixed(2) }}<br>
				<span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span> -->
			</span>

			<span class='price' v-if="!disc">CAD ${{ item.pricel.toFixed(2) }}<br>
				<span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span>
			</span>
			
			<router-link :to="{
				name:'ItemDetails',	
				params:{id:item.item}
			}" tag='button' class='btn btn-primary'>
				Details
			</router-link>
			

		</div>
	
	</div>
</template>

<script>

	export default{
		props: ['item'],
		data(){
			return {
				storage:window.localStorage,
				userInfo:[],
				usdPrice:this.$store.state.usdPrice,
				onsale:false,
				disc:true,
				
				
				
			}
		},
		mounted(){
			this.item.pricel = this.Dealerprice(this.item);

			if (this.ifDealer()) {
				this.disc = false;
			}else{
				if (this.item.onhand-this.item.aloc > this.item.orderpt) {
					this.disc = true;
				}else{
					this.disc = false;
				}
			}
		},

		filters:{
			discount10(price) {
				return (price * 0.9).toFixed(2);
			}
		},
		computed:{
			
		},

		methods:{
			goToItem($item){
				this.$router.push({
					name:'ItemDetails',
					params:{
						id:$item,
					}
				});
			}
		}
		
	}
</script>

<style scoped>
	.item{
		margin:20px 0;
		width: 260px;
	}
	.img{
		background-position: center;
		background-size: 80%;
		background-repeat: no-repeat;
		height: 250px;
		cursor: pointer;
	}
	.words{
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	button{
		width:150px;
	}
	.price{
		color: red;
		font-size: 1.2em;
		font-weight: bold;
		padding: 10px 0 ;
		min-height: 80px;
	}
	.description{
		color: black;
		font-weight: bold;
		text-transform: uppercase;
	}

	
</style>
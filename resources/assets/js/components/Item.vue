<template>
	<div class='item'>
		
		<div class="img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }" @click='goToItem(item.item)'>	
			
		</div>
		<div class="words">
			
			<small>Product No: {{ item.item}}</small>
			
			<span class='description'>{{ item.descipt}}</span>
			
			<small>Year Fit: {{ item.year_begin}} -- {{item.year_end}}</small>
			
			<small>Make: {{ item.make}} </small>
			
			<span class='price'>CAD ${{ item.pricel.toFixed(2) }}<br>
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
				
			}
		},
		mounted(){
			this.item.pricel = this.Dealerprice(this.item);
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
		background-size: 100%;
		background-repeat: no-repeat;
		height: 250px;
		cursor: pointer;
	}
	.words{
		display: flex;
		flex-direction: column;
	}
	button{
		width:150px;
	}
	.price{
		color: red;
		font-size: 2em;
		font-weight: bold;
		padding: 10px 0 ;
	}
	.description{
		color: black;
		font-weight: bold;
		text-transform: uppercase;
	}
</style>
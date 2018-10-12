<template>
	<div class='item'>
		
		<div class="img" :style="{ backgroundImage: 'url(' + item.img_path + ')' }" @click='goToItem(item.item)'>	
			
		</div>
		<div class="words">
			
			<small>Product No: {{ item.item}}</small>
			
			<span class='description'>{{ item.descipt}}</span>
			
			<small>Year Fit: {{ item.year_begin}} -- {{item.year_end}}</small>
			
			<small>Make: {{ item.make}} </small>
			
			<span class='price'>${{ price.toFixed(2) }}</span>
			
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
				
			}
		},
		mounted(){
			let userInfo = JSON.parse(this.storage.getItem('userInfo'));
			let user = JSON.parse(this.storage.getItem('user'));
			if (user.level==2) {
				
				switch (userInfo.pricecode) {
					case 4:
						this.item.pricel = item.price1;
						break;
				
					default:
						break;
				}

			}
		},

		computed:{
			price(){
				let userInfo = JSON.parse(this.storage.getItem('userInfo'));
				let user = JSON.parse(this.storage.getItem('user'));
				let myPrice=this.item.pricel;
				if (user.level==2) {
					switch(userInfo.pricecode) {
						case '4':
							myPrice = this.item.price4;
							break;
						case '3':
							myPrice = this.item.price3;
							break;
						case '2':
							myPrice = this.item.price2;
							break;
						case '1':
							myPrice = this.item.price;
							break;
						default:
							myPrice = this.item.pricel;
							break;
					
					}

				}else{

				}
				
				return myPrice;
			}
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
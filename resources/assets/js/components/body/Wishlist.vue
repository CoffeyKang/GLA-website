<template>
	<div class='container'>
		
		<div class='wishBody'>
			<div class='wishilist-items container-fuild col-xs-9'>
				<div v-for="item in items" :key="item.item">
					<div class="wishlist-item container-fuild ">
						<div class='item-img' :style="{ backgroundImage: 'url(' + item.img_path + ')' }">
							
						</div>

						<div class="item-details">
							<span class='descrip'>{{ item.descrip.toUpperCase() }}</span>
							<span class='item-info'>Product NO: {{ item.item }}</span>
							<span class='item-info'>Year Fit:{{ item.year_from }} - {{ item.year_end}}</span>
							<span class='item-info'>Make: {{ item.make }}</span>
						</div>

						<div class="item-action">
							<span class='glyphicon glyphicon-remove text-right'></span>
							<span class="price text-right">PRICE: $ {{ item.pricel.toFixed(2) }}</span>
							<div class='text-right'>
								<button class="btn btn-info text-right add">Add to Cart</button>
							</div>
						</div>
					    
					</div>  
					
				</div>

			</div>
			<div class="wishlist-action col-xs-3">
				<table class='col-xs-12'>
					<tr>
						<td class='action-title'>MANAGE MY LIST</td>
					</tr>
					<tr>
						<td class='action-info'><span class='glyphicon glyphicon-download'></span> Email My List</td>
					</tr>
					<tr>
						<td class='action-info' @click='open2'><span class='glyphicon glyphicon-remove-circle
' ></span> Clear My List</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				items:{},
				storage:window.localStorage,
			}
		},
		mounted(){
			
			// check if user is login
			if(this.storage.getItem('userInfo')){
				
				let userData = JSON.parse(this.storage.getItem('userInfo'));
			}else{
				this.$store.commit('changeLoginDirect','wishlist');
				this.$router.push('Login');
			}

			this.$http.get('/api/wishlist').then(response=>{
				this.items = response.data.items;
				console.log(this.items);
			}, response=>{
				console.log('wishlist error');
			});

		},
		methods:{
			open2(){
		        this.$confirm('Are you sure to clear the wishlist?', 'Warning', {
		          confirmButtonText: 'Empty',
		          cancelButtonText: 'Cancel',
		          type: 'warning'
		        }).then(() => {
		        	console.log('delete the wishlist table');
		          this.$message({
		            type: 'success',
		            message: 'Clean Successfully!'
		          });
		        }).catch(() => {
		          this.$message({
		            type: 'info',
		            message: 'Action Canceled.'
		          });          
		        });
		      }
		}
	}
</script>

<style scoped>
	
	.wishBody{
		display: flex;
		justify-content: space-between;
		
	}
	
	.wishlist-item{
		display: flex;
		border: 1px gray solid;
		margin-top: 10px;
		margin-bottom: 10px;
		
		
	}
	.item-img{
	    background-position: 50%;
	    background-repeat: no-repeat;
	    background-size: 100%;
	    height: 180px;
	    width: 180px;
	    margin:10px;

	}

	.item-details{
		height: 180px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		width: 300px;
		padding: 20px;
	}

	.descrip{
		font-size: 1em;
		color: black;
		font-weight: bold;
	}
	.item-info{
		color: gray;
	}

	.item-action{
		height: 180px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		width: 300px;
		padding: 20px 0px;
	}
	.price{
		font-size: 1.6em;
		font-weight: bold;
		line-height: 80px;
	}

	.add{
		font-size: 1.6em;
		padding-left: 10px;
		padding-right: 10px; 
	}

	.wishlist-action{
		margin-top: 10px;
		padding-right: 0 !important;
	}

	table tr, table td{
		border:1px gray solid;
	}
	.action-title{
		font-size: 1.6em;
		padding: 10px
	}
	.action-info{
		font-size: 1.2em;
		padding: 10px;
		cursor: pointer;
	}
	
</style>
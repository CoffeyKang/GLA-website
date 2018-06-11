<template>
	<div class='container'>
		
		<div class='wishBody'>
			<div class='wishilist-items container-fuild col-sm-8'>
				<div class="container-fulid oneItem" v-for="item in items" :key="item.item" >
                <div class='singleItem'>
                    <div class="itemImg" >
                        <div id="itemImg" :style="{ backgroundImage: 'url(' + item.img_path + ')' }">
                            
                        </div>
                    </div>
                    <div class="itemDetails">
                        <div class="desc">
                            <span class='title'>{{item.descrip}}</span>
                            <span class='info'>Product No: {{item.item}}</span>
                            <span class='info'>Year Fit: {{item.year_from}} -- {{item.year_end}}</span>
                            <span class='info'>Make: {{item.make}}</span>
                        </div>
                        
                        
                        <div class="instock">
                            In-stock: {{item.onhand}}
                        </div>
                    </div>
                    <div class="item_action text-right">
                        <div class="closure ">
                            <span class="glyphicon glyphicon-remove" @click="removeFromWhishlist(item)"></span>
                        </div>
                        
                        <div class="price">
                            <span>
                                PRICE: $ {{item.pricel}}
                            </span>
                            <span>
                                <button class="btn btn-success" @click="addToCart(item)">Add To Cart</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

			</div>
			<div class="wishlist-action col-sm-4">
				<table class='col-xs-12'>
					<tr>
						<td class='action-title' >MANAGE MY LIST</td>
					</tr>
					
					<tr>
						<td class='action-info' @click='clearWish()'><span class='glyphicon glyphicon-remove-circle
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

			this.getWishlist();

		},
		computed:{
			carts_number(){
				return this.$store.state.carts_total;
			}
		},
		methods:{
			clearWish(){
				  this.$http.post('/api/clearWishlist',{user:JSON.parse(this.storage.getItem("user")).id}).then(response=>{

						const h = this.$createElement;
						this.$notify({
						title: 'Succsesfully Clear.',
						message: h('b', { style: 'color: teal' }, 'The Wish list was cleared')
						});
					},response=>{

					});
			},
			removeFromWhishlist(item){
				var user = JSON.parse(this.storage.getItem("user")).id;
				this.$http.post('/api/removeFromWishlist',{user:user,item:item.item})
					.then(response=>{
						console.log(response.data);
						if (response.data==1) {
							this.items={},
							this.getWishlist();
							// this.items.remove(item);
						}else{

						}
					}, response=>{
						console.log('error');
					});
			},
			// addToCart
			addToCart(item){ 
				if (item.onhand<1) {
					this.$alert('Out of stock', 'Warning', {
						confirmButtonText: 'OK',
					});
				}else{
					if (window.localStorage.getItem(item.item)) {
						var qty = parseInt(window.localStorage.getItem(item.item)) + 1;
						window.localStorage.setItem(item.item,qty);
					}else{
						window.localStorage.setItem(item.item,1);
						var newNumber = this.carts_number + 1;
						this.$store.commit('carts_number',newNumber);
					}

					const h = this.$createElement;
					this.$notify({
						title: 'Succsesfully.',
						message: h('b', { style: 'color: teal'}, 'The item has been already put into shopping cart')
					});

					console.log(window.localStorage);
				}

				this.removeFromWhishlist(item);
				
			},


			getWishlist(){
				this.$http.get('/api/wishlist').then(response=>{
					this.items = response.data.items;
					console.log(this.items);
				}, response=>{
					console.log('wishlist error');
				});
			}
		},

	}
</script>

<style scoped>
	.oneItem{
        border: 1px solid black;
        margin: 15px 0;

    }
    .itemImg{
        width: 30%;
        height: 250px;
    }
    #itemImg{
        margin-top: 30px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        height: 80px;
    }
    .itemDetails{
        width: 40%;
        padding: 30px;
        height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .item_action{
        width: 30%;
        padding: 30px;
        height: 250px;
    }
    .singleItem{
        display: flex;
    }
    .desc{
        display: flex;
        flex-direction: column;
    }
    .info{
        color: gray;
        font-size: 12px;
    }
    .qty{
        display: flex;
    }
    .update_link{
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: flex-end;
    }
    .instock{
        font-size: 18px;
        font-weight: bold;
        color: #009456;
    }
    .item_action{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .toWish{
        font-size: 16px;
        color: red;
    }
    .price{
        display: flex;
        flex-direction: column;
        font-size: 18px;
        font-weight: bold;
    }
    .glyphicon{
        cursor: pointer;
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
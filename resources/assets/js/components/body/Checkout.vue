<template>
    <div class="container">
        <h3>Checkout</h3>
        <div class="col-sm-8" style='padding:0;'>
             <table class="table table-striped table-justified">
                 <thead>
                    <tr>
                        <th>Description</th>
                        <th>Item</th>
                        <th>Make</th>
                        <th>QTY</th>
                        <th>Price</th>
                    </tr>
                 </thead>
                 <tbody>
                     <tr v-for="item in carts" :key="item.item" v-if="carts.length>=1" class='text-left'>
                         <td>{{item.descrip}}</td>
                         <td>{{item.item}} </td>
                         <td>{{item.make}}</td>
                         <td>{{item.qty}}</td>
                         <td>$ {{(item.price * item.qty).toFixed(2)}}</td>
                     </tr>
                 </tbody>
             </table>
            <!-- <div class="container-fulid oneItem" v-for="item in carts" :key="item.item" v-if="carts.length>=1">
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
                        
                        <div class="qty">
                            <b style='width:50px; height:28px;line-height:28px;'> QTY: {{ item. qty }} </b>
                            
                            
                        </div>
                        
                    </div>
                    <div class="item_action text-right">
                        
                        <div class="price">
                            <span>
                                PRICE: $ {{item.price.toFixed(2)}}
                            </span>
                            <span>
                                TOTAL: $ {{(item.price * item.qty).toFixed(2)}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fulid oneItem alert alert-warning" v-if="carts.length<1" style='border:0'>
                <h5>Your Shopping Cart is empty.</h5>
                
            </div> -->
        </div>
        <div class="col-sm-4" style='padding-right:0;padding-top:15px; padding-left:30px;'>
            
            <div class="summary" >
                <div class="summary_title">
                    ORDER SUMMARY
                </div>
                <div class="summary_details">
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>SUBTOTAL:</span><span>${{ subtotal }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>SHIPPING:</span><span>${{ shipping }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>HST:</span><span>${{ hst }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>TOTAL:</span><span>${{ total.toFixed(2) }}</span>
                        </div>
                    </div>
                </div>

                <div class=" text-center">
                    <button class='mybtn btn btn-success' @click='placeOrder()'>Place Order</button>
                    <button class='mybtn btn btn-warning' @click='$router.push("shoppingCart")'>Edit Order</button>
                </div>
                
            </div>
        </div>
        
    </div>
</template>
<script>

export default {
    data(){
        return {
            items:[],
            qtys:[],
            storage:window.localStorage,
            carts:[],
            subtotal:0,
            shipping:0,
            hst:0,
            
            
            }
        },
        computed:{
            total:function(){
                return parseFloat(this.subtotal) + parseFloat(this.hst);
            }
        },
        mounted(){
            // determin if user has login
			if(this.storage.getItem('user')){
				// have to validate the user name and password once more here
                var userData = JSON.parse(this.storage.getItem('user'));

                /** check again */
                this.$http.get('/api/shortlist',{params:{userid:userData.id}}).then(response=>{
                    console.log(response);
                    this.carts = response.data.carts;
                    this.subtotal = response.data.subtotal.toFixed(2);
                    this.hst = response.data.tax_total.toFixed(2);
                });

			}else{
				this.$store.commit('changeLoginDirect','home');
				this.$router.push('Login');
            }
        },
        methods:{
        },
        watch:{
        }
    

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
        justify-content:flex-end;
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

    .summary{
        border:1px solid black;
        height: 500px;
    }
    .summary_details{
        padding: 15px;
    }
    .summary_details div{
        display: flex;
    }
    .summary_list{ 
        display: flex;
        flex-direction: column;
        height: 60px;

    }
    .summary_title{
        font-size: 28px;
        font-weight: bold; 
        padding: 15px;
        border-bottom: 1px solid black;
    }
    
    .summary_amount{
        display: flex;
        justify-content: space-between;
        font-size: 20px;
        font-weight: bold;
        border-bottom: 1px solid black;
    }
    .mybtn{
        border: none;
        color: white;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .fakeLink{
        cursor: pointer;
        
    }
    
</style>


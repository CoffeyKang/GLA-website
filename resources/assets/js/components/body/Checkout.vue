<template>
    <div class="container">
        <h3>Checkout</h3>
        <div class="col-sm-8" style='padding:0;'>
            <div>
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
            </div>
            <div class='shipingTo'>
                <h4>Shipping To</h4>
                <el-card class="box-card col-xs-6" >
                    <div>
                        <h5>{{userInfo.m_forename}} {{userInfo.m_surname}} <br>
                        {{userInfo.m_address}},  {{userInfo.m_city}}, {{userInfo.m_zipcode}}<br>
                        {{userInfo.m_state}}, {{userInfo.m_country}}</h5>
                        <div class='shipToAddress'>
                        <button class="  btn btn-warning text-center">
                            Edit Address
                        </button>
                        </div>
                    </div>
                </el-card>
                
                
            </div>
            
            
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
                            <span>SHIPPING:</span><span v-if="shippingRate=='quotable'">${{ shipping }}</span>
                            <span v-if="shippingRate!='quotable'">TBD</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>HST:</span><span>${{ hst }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>TOTAL:</span><span v-if="shippingRate=='quotable'">${{ total.toFixed(2) }}</span>
                            <span v-if="shippingRate!='quotable'">TBD</span>
                        </div>
                    </div>
                </div>

                <div class=" text-center" v-if="shippingRate=='quotable'">
                    <button class='mybtn btn btn-success' @click='placeOrder()'>Place Order</button>
                    <button class='mybtn btn btn-warning' @click='$router.push("shoppingCart")'>Edit Order</button>
                </div>

                <div class="text-center shippingOPT ">
                    <el-radio-group v-model="shippingOPT" v-if="shippingRate=='quotable'">
                        <el-radio :label="1">Ground Shipping, taking <b>{{parseInt(groundDay) +3}}</b> days</el-radio><br>
                        <el-radio :label="2">Express Shipping, taking <b>{{parseInt(expressDay) +1}}</b> days</el-radio>
                    </el-radio-group>
                </div>

                <div class=" text-center" v-if="shippingRate!='quotable'">
                    <button class='mybtn btn btn-success' >Get a Quote</button>
                    
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
            hst:0,
            quotes:[],
            shippingOPT:1,
            expressDay:1,
            groundDay:1,
            shippingRate:'',
            }
        },
        computed:{
            total:function(){
                return parseFloat(this.subtotal) + parseFloat(this.hst) + parseFloat(this.shipping);
            },
            shipping:function(){
                if (this.shippingOPT==1) {
                    return this.quotes['ground'];
                }else{
                    return this.quotes['express'];
                }
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
                    this.userInfo = response.data.userInfo;
                    
                    this.shippingRate = response.data.shippingRate;
                    this.quotes = response.data.quotes;
                    this.shipping = this.quotes['ground'];
                    this.groundDay = response.data.groundDay;
                    this.expressDay = response.data.expressDay;


                    
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
    .shippingOPT{
        padding: 20px;
    }

    .shipToAddress{
        display: flex;
        justify-content: space-around;
    }
    
    
</style>


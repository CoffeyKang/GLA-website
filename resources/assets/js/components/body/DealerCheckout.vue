<template>
    <div class="container" v-loading='loading'  
		element-loading-text="Calculating ..."
        style='margin-bottom:30px;'
	>
        <h3>Confirm Order</h3>
        <el-steps :active="2" finish-status="success">
            <el-step title="Step 1"></el-step>
            <el-step title="Step 2"></el-step>
            <el-step title="Step 3"></el-step>
            <el-step title="Step 4"></el-step>
        </el-steps>
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
                            <td>${{(item.price * item.qty).toFixed(2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class='shipingTo'>
                    <div class='col-xs-12' >
                        <h4>Shipping To</h4>
                        <el-card class="box-card" >
                                <h5><b>{{dealerInfo.company}} </b> <br> <br>
                                {{dealerInfo.address1}},  {{dealerInfo.city}}, {{dealerInfo.zip}}<br>
                                {{dealerInfo.terr}}, {{dealerInfo.country}}<br>{{dealerInfo.phone}}</h5>
                        </el-card>
                    </div>

                    


                    <div class='col-xs-12'  style='margin-top:20px;'>
                        <h4>Shipping To another address</h4>
                        <div style='display:flex; justify-content:space-between'> 
                        <el-select v-model="selectAdd" placeholder="To default address.">
                            <el-option
                            v-for="item in addressBook"
                            :key="item.cshipno"
                            :label="item.cshipno"
                            :value="item.cshipno">
                            </el-option>
                        </el-select>
                        
                        </div>
                    </div>
                <div class='addressBook col-xs-12' >
                    <div class='address' v-for="address in addressBook" :key="address.cshipno" v-if="address.cshipno==selectAdd">
                        <el-card class="box-card addressBox" :id="'box'+address.cshipno" >
                               <h5><b>{{dealerInfo.company}} </b> <br> <br>
                                {{dealerInfo.address1}},  {{dealerInfo.city}}, {{dealerInfo.zip}}<br>
                                {{dealerInfo.terr}}, {{dealerInfo.country}}<br>{{dealerInfo.phone}}
                                </h5>
                                <div class='shipToAddress'>
                                    <button class=" btn btn-success text-center" @click='changeAddress(address)'>
                                        Deliver to address
                                    </button>

                                    <button class=" btn btn-default text-center" @click='defaultAddress()'>
                                        Default Address
                                    </button>
                                    
                                </div>
                        </el-card>
                    </div>
                </div>

                
                
                
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
                            <span>SUBTOTAL:</span><span>${{ parseFloat(subtotal).toFixed(2) }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>SHIPPING:</span><span v-if="shippingRate=='quotable'">${{ parseFloat(shipping).toFixed(2) }}</span>
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

                

                

                <div class=" text-center" >
                    <button class='mybtn btn btn-success' @click='confirm()'>Get a Quote</button>
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
            hst:0,
            addressID:0,
            quotes:[],
            shippingOPT:1,
            expressDay:1,
            groundDay:1,
            shippingRate:'',
            dealerInfo:[],
            loading:1,
            addressBook:[],
            selectAdd:'',
        }
    },
        computed:{
            total:function(){
                
                return parseFloat(this.subtotal) + parseFloat(this.hst) + parseFloat(this.shipping);

            },
            

            
        },
        mounted(){
            // determin if user has login
			if(this.storage.getItem('user')){
				// have to validate the user name and password once more here
                var userData = JSON.parse(this.storage.getItem('user'));
                /** check again */
                this.$http.get('/api/DealerShortlist',{params:{userid:userData.id}}).then(response=>{
                    
                    this.carts = response.data.carts;
                    this.subtotal = response.data.subtotal.toFixed(2);
                    this.hst = response.data.tax_total.toFixed(2);
                    this.dealerInfo = response.data.dealerInfo;
                    this.loading = 0;
                    this.addressBook = response.data.addressBook;
                    if (this.carts.length<1) {
                        this.$router.push({name:'ShoppingCart'});
                    }else{
                        
                    }
                });

			}else{
				this.$store.commit('changeLoginDirect','home');
				this.$router.push('Login');
            }

            
        },
        methods:{
            
            changeAddress(address){

                // <h5><b>{{dealerInfo.company}} </b> <br> <br>
                //                 {{dealerInfo.address1}},  {{dealerInfo.city}}, {{dealerInfo.zip}}<br>
                //                 {{dealerInfo.terr}}, {{dealerInfo.country}}<br>{{dealerInfo.phone}}</h5>

                this.dealerInfo.company = address.company;
                this.dealerInfo.address = address.address1;
                this.dealerInfo.city = address.city;
                this.dealerInfo.zip = address.zip;
                this.dealerInfo.terr = address.terr;
                this.dealerInfo.country = address.country;
                this.dealerInfo.phone = address.phone;

                $('.addressBox').css("border",'none');
                $("#box"+address.cshipno).css("border",'3px solid green');

        


            },

            defaultAddress(){
                var userData = JSON.parse(this.storage.getItem('user'));
                this.$http.get('/api/DealerShortlist',{params:{userid:userData.id}}).then(response=>{
                    
                    this.carts = response.data.carts;
                    this.subtotal = response.data.subtotal.toFixed(2);
                    this.hst = response.data.tax_total.toFixed(2);
                    this.dealerInfo = response.data.dealerInfo;
                    this.loading = 0;
                    this.addressBook = response.data.addressBook;
                    this.selectAdd = '';
                    if (this.carts.length<1) {
                        this.$router.push({name:'ShoppingCart'});
                    }else{
                        
                    }
                });
            },
            
           

           
           

            confirm(){
                this.loading = 0;
                
               

               
                
            },
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
    .address{
        min-width: 350px;
        margin-top:20px;
    }
    .addressBook{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .newShipping{
        margin-top: 20px;
        margin-bottom:20px;
    }

    .inRow{
        display: flex;
        justify-content: space-between;
        
    }
    
</style>


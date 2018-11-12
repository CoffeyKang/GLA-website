<template>
    <div class="container" v-loading='loading'  
		element-loading-text="Calculating ..."
        style='padding-bottom:30px;'
	>
        <h3>Payment</h3>
        <el-steps :active="3" finish-status="success">
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

            <div class='shipingTo col-xs-6'>
                    <div class='' >
                        <h4 style='display:flex;justify-content:space-between'><div>Billing Address</div> <div style='font-size:80%;cursor:pointer' @click='$router.push({path:"/CustomerInfo/ChangeProfile"})'>Edit</div></h4>
                        <el-card class="box-card">
                                <h5><b>{{billing.firstname}} {{billing.lastname}}</b> <br> <br>
                                {{billing.address1}},{{billing.address2}}, {{billing.city}}, {{billing.postalcode}}<br>
                                {{billing.province}}, {{billing.country}}</h5>
                        </el-card>

                        
                    </div>

                    
            </div>
            <div class='shipingTo col-xs-6'>
                    <div class='' >
                        <h4>Shipping Address </h4>
                        <el-card class="box-card" v-if="addressID!=0">
                                <h5><b>{{address.forename}} {{address.surname}}</b> <br> <br>
                                {{address.address}}, {{address.city}}, {{address.zipcode}}<br>
                                {{address.state}}, {{address.country}}</h5>
                        </el-card>
                        <el-card class="box-card" v-if="addressID==0">
                                <h5><b>{{userInfo.m_forename}} {{userInfo.m_surname}}</b> <br> <br>
                                {{userInfo.m_address}},  {{userInfo.m_city}}, {{userInfo.m_zipcode}}<br>
                                {{userInfo.m_state}}, {{userInfo.m_country}}</h5>
                        </el-card>
                    </div>
            </div>

            <div class="col-xs-12 ">
                <fieldset>
                    <legend>Card Information</legend>
                    <div class="control-group col-xs-4">
                        <label label-default="" class="control-label">Card Holder's Name</label>
                        <div class="controls">
                            <input type="text" id='cardName' class="form-control" pattern="\w+ \w+.*" placeholder="Name on card" required v-model='card.name'>
                        </div>
                    </div>
                    <div class="control-group col-xs-8">
                        <label label-default="" class="control-label">Card Number</label>
                        <div class="controls">
                            <div class="row">
                                <div>
                                    <input type="text" id='cardNumber' class="form-control" v-model='card.card' autocomplete="off" minlength="16" maxlength="16"  placeholder="Input your card number" required >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group col-xs-6">
                        <label label-default="" class="control-label">Card Expiry Date</label>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" name="cc_exp_mo" v-model='card.month'>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    
                                    <select class="form-control" name="cc_exp_yr" v-model='card.year' >
                                        <option v-for="year in myYear(2000)" :key="year">{{year}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group col-xs-6">
                        <label label-default="" class="control-label">Card CVV</label>
                        <div class="controls">
                            <div class="row">
                                <div>
                                    <input type="text" id='cardCVV' v-model='card.cvv' class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" placeholder="Three digits at back of your card">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="control-group col-xs-12 alert alert-danger" style='margin:15px 0;' v-if="paymentError">
                        <div class="col-xs-12">
                                {{error}}
                        </div>
                    </div>
                    
                </fieldset>
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
                            <span>SHIPPING:</span><span>${{ parseFloat(shipping).toFixed(2) }}</span>
                            
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>HST:</span><span>${{ parseFloat(hst).toFixed(2) }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>TOTAL:</span><span>${{ parseFloat(total).toFixed(2) }}</span>
                            
                        </div>
                    </div>

                    <div class=' summary_list text-center'>
                        <h5>Estimate Shipping Date : {{ shippingDays }} Days</h5>
                    </div>

                    <div class=' summary_list text-center'>
                        <button class='mybtn btn btn-success' @click="placeOrder()">Place Order</button>
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
            carts:this.$route.params.carts,
            addressID:this.$route.params.addressID,
            subtotal:this.$route.params.subtotal,
            hst:this.$route.params.hst,
            total:this.$route.params.total,
            subtotal:this.$route.params.subtotal,
            shippingDays:this.$route.params.shippingDays,
            shipping:this.$route.params.shipping,
            loading:0,
            userInfo:[],
            address:[],
            billing:[],
            edit:false,
            card:{
               month:(new Date()).getMonth() +1,
               year:(new Date()).getFullYear(),
            },
            paymentError:false,
            error:'',

        }
    },
        computed:{
            
            
        },
        mounted(){
            // determin if user has login
			if(this.storage.getItem('user')&&this.storage.getItem('userInfo')){
				// have to validate the user name and password once more here
                var userData = JSON.parse(this.storage.getItem('user'));
                 this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
                 this.billing = JSON.parse(this.storage.getItem('billing'));
                /** check again */
                
			}else{
				this.$store.commit('changeLoginDirect','home');
				this.$route.push('Login');
            };
            if (isNaN(this.subtotal)) {
                this.$store.commit('confirm',true);
                this.$router.push({name:'checkout'});
            }else{

            }
            if (this.addressID!=0) {
                this.$http.get('/api/address/'+this.addressID).then((response)=>{
                    if (response.data.address=='notFound') {
                        
                    }else{
                        this.address = response.data.address;

                    }

                });
            }

           if (this.card.month<10) {
               this.card.month = "0" + toString(this.card.month);
           }
        },
        methods:{
            placeOrder(){
                this.loading = 1;
                if (!this.card.name || !this.card.card || !this.card.cvv || this.card.card.length<16) {
                    if (!this.card.name) {
                        $('#cardName').css('border','1px solid red');
                    }else{}
                    
                    if (!this.card.card || this.card.card.length<16){
                        $('#cardNumber').css('border','1px solid red');
                    }else{
                    }

                    if (!this.card.cvv){
                       
                        $('#cardCVV').css('border','1px solid red');
                    }else{

                    }
                    this.loading = 0;
                    return false;
                }else{
                    
                    this.$http.post('/api/finishOrder',
                        {   
                            custno:JSON.parse(this.storage.getItem('user')).id,
                            billing:this.billing,
                            address:this.address,
                            hst:this.hst,
                            total:this.total,
                            subtotal:this.subtotal,
                            shippingDays:this.shippingDays,
                            shipping:this.shipping,
                            card:this.card,
                            addressID:this.addressID,
                        }
                        ).then(response=>{
                        this.loading = 0;
                        if (response.data.result) {
                            this.carts.forEach(element => {
                                this.storage.removeItem(element.item);
                                this.$store.commit('carts_number',0);
                            });

                            this.$router.push({name:'FinishOrder', params:{order_num:response.data.result.order_number}});
                        }else{
                            this.paymentError = true;

                            this.error='Declined please try again';
                        }
                    });
                }
                
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


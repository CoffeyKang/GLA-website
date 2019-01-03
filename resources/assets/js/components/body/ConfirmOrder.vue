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
        <div class="col-xs-12 col-sm-8" style='padding:0;'>
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

            <div class='shipingTo col-xs-12 col-sm-6'>
                    <div class=''>
                        <h4 style='display:flex;justify-content:space-between'><div>Billing Address</div> <div style='font-size:80%;cursor:pointer' @click='$router.push({path:"/CustomerInfo/ChangeProfile"})'>Edit</div></h4>
                        <el-card class="box-card">
                                <h5><b>{{billing.firstname}} {{billing.lastname}}</b> <br> <br>
                                {{billing.address1}},{{billing.address2}}, <br>{{billing.city}}, {{billing.province}}, {{billing.postalcode}}<br>
                                 {{billing.country}}</h5>
                        </el-card>
                    </div>

                    
            </div>
            <div class='shipingTo col-xs-12 col-sm-6'>
                    <div class='' v-if="!pickupInstore">
                        <h4>Shipping Address</h4>
                        <el-card class="box-card" v-if="addressID!=0">
                                <h5><b>{{address.forename}} {{address.surname}}</b> <br> <br>
                                {{address.address}}, <br>{{address.city}}, {{address.state}}, {{address.zipcode}}<br>
                                {{address.country}}</h5>
                        </el-card>
                        <el-card class="box-card" v-if="addressID==0">
                                <h5><b>{{userInfo.m_forename}} {{userInfo.m_surname}}</b> <br> <br>
                                {{userInfo.m_address}},  {{userInfo.m_city}}, {{userInfo.m_zipcode}}<br>
                                {{userInfo.m_state}}, {{userInfo.m_country}}</h5>
                        </el-card>
                    </div>

                    <div class='' v-if="pickupInstore">
                        <h4>Shipping Address</h4>
                        <el-card class="box-card">
                                <h5><b>GOLDEN LEAF AUTOMOTIVE</b> <br> <br>
                                170 ZENWAY BLVD UNIT#2 WOODBRIDGE, ONTARIO L4H 2Y7<br>
                                TELEPHONE 905/850-3433</h5>
                        </el-card>
                        
                    </div>
            </div>


            <div class="col-xs-12 payments">
                <fieldset class='col-xs-12' style='padding:0'>
                    <legend>Payment Options</legend>
                    <img src="/images/card.png" alt=""  @click='opt_card()'>
                    <img src="/images/paypal.png" alt="" @click='opt_paypal()'>

                
                </fieldset>

            </div>
            <div class="col-xs-12 ">
                <fieldset  v-if="opt_card_status">
                    <legend>Card Information -- We do not store your credit card details.</legend>
                    <div class="control-group col-sm-8">
                        <label label-default="" class="control-label">Card Holder's Name</label>
                        <div class="controls">
                            <input type="text" id='cardName' class="form-control" pattern="\w+ \w+.*" placeholder="Name on card" required v-model='card.name'>
                        </div>
                    </div>
                    <div class="control-group col-sm-4">
                         
                    </div>

                    <div class="control-group col-sm-8">
                        <label label-default="" class="control-label">Card Number</label>
                        <div class="controls">
                            <input type="text" id='cardNumber' class="form-control" v-model='card.card' autocomplete="off" minlength="16" maxlength="16"  placeholder="Input your card number" required >
                        </div>
                    </div>
                    

                    <div class="control-group col-sm-6">
                        <label label-default="" class="control-label">Card Expiry Date</label>
                        <div class="controls">
                            <div class="row">
                                <div class="col-xs-5 col-sm-5">
                                    <input type="number"  class="form-control" id ='cardMonth' v-model='card.month' autocomplete="off" minlength="2" maxlength="2"  placeholder="MM" required >
                                    
                                </div>
                                <div class="col-xs-1 col-sm-1" style='font-size:32px; line-height:36px;'> / </div>
                                <div class="col-xs-5 col-sm-6">
                                    <input type="number" id ='cardYear'  class="form-control" v-model='card.year' autocomplete="off" minlength="4" maxlength="4"  placeholder="Year" required >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group col-sm-6">
                        <label label-default="" class="control-label">Card CVV</label>
                        <div class="controls">
                            <div class="row">
                                <div class='col-sm-4'>
                                    <input type="text" id='cardCVV'  v-model='card.cvv' class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" placeholder="Three digits at back of your card">
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

                <fieldset  v-if="opt_paypal_status">
                    <legend>Pay with Paypal and Accept our shipping policy.</legend>
                    <!-- <div id="paypal-button" ></div> -->
                    <PayPal
                        :amount="parseFloat(total).toFixed(2).toString()"
                        currency="CAD"
                        :client="credentials"
                        env="sandbox"
                        locale="en_CA"
                        :button-style="myStyle"
                        :items="myItems"
                        v-on:payment-authorized="paymentAuthorized"
                        v-on:payment-completed="paymentCompleted"
                        v-on:payment-cancelled="paymentCancelled"
                        >
                    </PayPal>
                </fieldset>
            </div>

            

        </div>
        <div class="col-xs-12 col-sm-4 mobile_total" style='padding-right:0;padding-top:15px; padding-left:30px;'>
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

                    <div class="summary_list">
                        <h4>NOTES: {{notes}}</h4>
                    </div>

                    <div class=' summary_list text-center'>
                        <h5 v-if="!pickupInstore">Estimate Shipping Time : {{ shippingDays }} Days</h5>
                    </div>

                    <div class=' summary_list text-center' v-if="opt_card_status">
                        <el-checkbox v-model="accept">Accept our shipping policy</el-checkbox>
                    </div>
                    <div class=' summary_list text-center' v-if="opt_card_status">
                        
                        <button class='mybtn btn btn-success' @click="placeOrder()" :disabled='!accept'>Place Order</button>
                    </div>
                    
                </div>
                    
            </div>
            
        </div>


        
        
        
    </div>
</template>
<script>
import PayPal from 'vue-paypal-checkout';
export default {
    data(){
        return {
            carts:this.$route.params.carts,
            addressID:this.$route.params.addressID,
            subtotal:this.$route.params.subtotal,
            hst:this.$route.params.hst,
            total:this.$route.params.total,
            notes:this.$route.params.notes,
            pickupInstore:this.$route.params.pickupInstore,
            amount:'',
            subtotal:this.$route.params.subtotal,
            shippingDays:this.$route.params.shippingDays,
            shipping:this.$route.params.shipping,
            loading:0,
            userInfo:[],
            address:[],
            billing:[],
            edit:false,
            card:{
               
            },
            paymentError:false,
            error:'',
            credentials:{
                sandbox: 'ATfV_6npMrMesyae6j79hpW_CL34aDZ53aP7gtQPmAs2TE7d_DghKrGr3CGTyZpzl-HRpUAtaM1ipZNU',
                production: 'Abv1eXljwmAwPW8de4uPkNR1no0sqfvLvKdQ22X4a2E0vbYamqgFWMeMzyJLtl8K5wOyNhEC8dRYc3FS'
            },
            myStyle: {
                label: 'checkout',
                size:  'responsive',
                shape: 'pill',
                color: 'gold'
            },
            opt_card_status:true,
            opt_paypal_status:false,
            myItems:[],
            accept:false,
            
        }
    },
        components: {
            PayPal
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
            }else{}

            if (this.pickupInstore) {
                this.address.forename = 'GOLDEN LEAF';
                this.address.surname = 'AUTOMOTIVE';
                this.address.address = '170 ZENWAY BLVD UNIT#2';
                this.address.city = 'WOODBRIDGE';
                this.address.zipcode = 'L4H 2Y7';
                this.address.state = 'ONTARIO ';
                this.address.country = 'CA';
            }else{}

           if (this.card.month<10) {
               this.card.month = "0" + toString(this.card.month);
           };


           /**  set my items */
           this.myItems = [
                {
                    "name": "Tax",
                    "description": "Tax.",
                    "quantity": "1",
                    "price": this.$route.params.hst,
                    "currency": "CAD"
                },
                {
                    "name": "Shipping",
                    "description": "Shipping Fee.",
                    "quantity": "1",
                    "price": this.$route.params.shipping,
                    "currency": "CAD"
                }
               
            ]

           
            this.carts.forEach(element => {
                var i = {
                    "name": element.item,
                    "description": element.descrip,
                    "quantity":element.qty,
                    "price": element.price,
                    "currency": "CAD"
                };

                this.myItems.unshift(i);
                
            });
            
            

            

        },
        methods:{
            placeOrder(){
                this.loading = 1;
                if (!this.card.name || !this.card.card || !this.card.month ||!this.card.year||!this.card.cvv || this.card.card.length<16||this.card.month.length<2||this.card.year.length<4) {
                    if (!this.card.name) {
                        $('#cardName').css('border','1px solid red');
                    }else{}
                    
                    if (!this.card.card || this.card.card.length<16){
                        $('#cardNumber').css('border','1px solid red');
                    }else{
                    }

                    if (!this.card.month || this.card.card.month<2){
                        $('#cardMonth').css('border','1px solid red');
                    }else{
                    }

                    if (!this.card.year || this.card.card.year<4){
                        $('#cardYear').css('border','1px solid red');
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
                            notes:this.notes,
                            pickupInstore:this.pickupInstore,
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

            paymentAuthorized: function (data) {
            },
            paymentCompleted: function (data) {
                this.loading = 1;
                this.$http.post('/api/finishOrder_paypal',
                    {   
                        custno:JSON.parse(this.storage.getItem('user')).id,
                        billing:this.billing,
                        address:this.address,
                        hst:this.hst,
                        total:this.total,
                        subtotal:this.subtotal,
                        shippingDays:this.shippingDays,
                        shipping:this.shipping,
                        addressID:this.addressID,
                        notes:this.notes,
                        pickupInstore:this.pickupInstore,
                    }
                    ).then(response=>{
                    this.loading = 0;
                    if (response.data.result) {
                        this.carts.forEach(element => {
                            this.storage.removeItem(element.item);
                            this.$store.commit('carts_number',0);
                        });

                        this.$router.push({name:'FinishOrder', params:{order_num:response.data.result.order_num}});
                    }else{
                        this.paymentError = true;

                        this.error='Declined please try again';
                    }
                });
            },
            paymentCancelled: function (data) {
            },
            opt_paypal(){
                this.opt_paypal_status = true;
                this.opt_card_status = false;
            },
            opt_card(){
                this.opt_card_status = true;
                this.opt_paypal_status = false;
            }
        },
        watch:{

        }
    

}
</script>
<style scoped>
::placeholder{color: gray}
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

    .payments{
        display: flex;
        flex-direction: row;
        margin: 30px 0;
        justify-content: left;

    }
    .payments img{
        height: 60px;
        cursor: pointer;
        margin-right: 50px;
        
    }
    .pmtopt{
        background-image: url('/images/img.jpg');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 100px;
        background-color: red;
    }

    @media screen and (max-width: 768px){
        .mobile_total{
            padding: 0 !important;
            margin-top: 30px;
        }
    }
    
</style>


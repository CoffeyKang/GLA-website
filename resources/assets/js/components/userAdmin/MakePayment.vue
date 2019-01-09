<template>
<div class='container' style='margin:30px auto;' v-loading='loading'  
		element-loading-text="Calculating ...">
    <div v-if="empty">
        <div class="alert alert-danger">
            Order not found. 
        </div>
    </div>
    <div v-if="!empty">
        
        <div class="edit_title" >
            <span>Make Payment For Order Number : {{so}} Complete</span><span v-if="show">Order Date : {{ (somast.date_order).substring(0,10) }}  </span>
        </div>

        <div class="col-xs-8">
            <div>
                <div class="col-xs-6 addessLabel">
                    <el-card class="box-card" >
                                <h4>Bill To</h4>
                                <h4>{{billing.firstname + ' ' +billing.lastname}}<br><br>{{billing.address1}},  {{billing.city}}, {{billing.postalcode}}<br>{{billing.province}}, {{billing.country}}<br>{{billing.phone}}</h4>
                        </el-card>
                </div>
                <div class="col-xs-6 addessLabel" >
                    <div  v-if="address==0" >
                        
                        <el-card class="box-card" >
                                <h4>Ship To</h4>
                                <h4>{{userInfo.m_forename + ' ' + userInfo.m_surname}} <br> <br>{{userInfo.m_address}},  {{userInfo.m_city}}, {{userInfo.m_zipcode}}<br>{{userInfo.m_state}}, {{userInfo.m_country}}<br>{{userInfo.m_tel}}</h4>
                        </el-card>
                    </div>

                    <div v-if="address!=0" >
                        <el-card class="box-card" >
                                <h4>Ship To</h4>
                                <h4>{{address.surname + ' ' + address.surname}} <br> <br>{{address.address}},  {{address.city}}, {{address.zipcode}}<br>{{address.state}}, {{address.country}}<br>{{address.tel}}</h4>
                        </el-card>
                    </div>
                </div>
            </div>
            
            
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <th>Item</th>
                    <th>QTY</th>
                    <th>Description</th>
                    <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in oneOrder" :key="item.order_serial">
                        <td>{{item.item}}</td>
                        <td>{{item.qty}}</td>
                        <th>{{item.descrip.toUpperCase()}}</th>
                        <td >$ {{item.price.toFixed(2)}}</td>
                    </tr>
                </tbody>
                
            </table>
        </div>
        <div class="col-xs-4" style='padding-right:0;padding-top:15px; padding-left:30px;'>
            <div class="summary" >
                <div class="summary_title">
                    ORDER SUMMARY
                </div>
                <div class="summary_details">
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>SUBTOTAL:</span><span>${{ parseFloat(somast.subtotal).toFixed(2) }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>SHIPPING:</span><span>${{ parseFloat(somast.shipping).toFixed(2) }}</span>
                            
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>HST:</span><span>${{ parseFloat(somast.tax).toFixed(2) }}</span>
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

                    <div class=' summary_list text-center' v-if="opt_card_status">
                        <el-checkbox v-model="accept">Accept our shipping policy</el-checkbox>
                    </div>
                    <div class=' summary_list text-center' v-if="opt_card_status">
                        
                        <button class='mybtn btn btn-success' @click="placeOrder()" :disabled='!accept'>Place Order</button>
                    </div>
                    
                </div>
                    
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
                    <div class="control-group col-xs-8">
                        <label label-default="" class="control-label">Card Holder's Name</label>
                        <div class="controls">
                            <input type="text" id='cardName' class="form-control" pattern="\w+ \w+.*" placeholder="Name on card" required v-model='card.name'>
                        </div>
                    </div>
                    <div class="control-group col-xs-4">
                         
                    </div>

                    <div class="control-group col-xs-8">
                        <label label-default="" class="control-label">Card Number</label>
                        <div class="controls">
                            <input type="text" id='cardNumber' class="form-control" v-model='card.card' autocomplete="off" minlength="16" maxlength="16"  placeholder="Input your card number" required >
                        </div>
                    </div>

                    <div class="control-group col-xs-6">
                        <label label-default="" class="control-label">Card Expiry Date</label>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="number"  class="form-control" id ='cardMonth' v-model='card.month' autocomplete="off" minlength="2" maxlength="2"  placeholder="MM" required >
                                    
                                </div>
                                <div class="col-md-1" style='font-size:32px; line-height:36px;'> / </div>
                                <div class="col-md-6">
                                    <input type="number" id ='cardYear'  class="form-control" v-model='card.year' autocomplete="off" minlength="4" maxlength="4"  placeholder="Year" required >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group col-xs-6">
                        <label label-default="" class="control-label">Card CVV</label>
                        <div class="controls">
                            <div class="row">
                                <div class='col-xs-4'>
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
                        env="production"
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
</div>        
</template>

<script>
import PayPal from 'vue-paypal-checkout';
export default {
    data(){
        return {
            so:this.$route.params.sono,
            storage:window.localStorage,
            account:0,
            oneOrder:[],
            shippingDays:0,
            somast:[],
            empty:false,
            show:false,
            total:0,
            address:[],
            userInfo:[],
            billing:[],
            
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
            loading:1,
        }
    },
    components: {
            PayPal
        },
    computed:{
        statusCode(){
            var status = '';
            switch (this.somast.sales_status) {
                case'':
                    status = 'Payment Failed';
                    break;
                case 1:
                    status = 'Paid';
                    break;
                case 3:
                    status = 'Pending for Quote';
                    break;
                case 5:
                    status = 'Pending for Reply';
                    break;
                case 7:
                    status = 'Under Process';
                    break;
                case 9:
                    status = 'Shipped';
                    break;
                default:
                    status = 'Shipped';
                    break;
            }

            return status;
        }
        
    },
    filters:{
        decimal:function(value){
                if (!isNaN(value)) {
                    return value.toFixed(2)
                }else{
                    return value;
                }
            }
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
                
                this.$http.post('/api/finishOrder_quote',
                    {   
                        custno:JSON.parse(this.storage.getItem('user')).id,
                        sono:this.so,
                        card:this.card,
                    }
                    ).then(response=>{
                    this.loading = 0;
                    if (response.data.result) {
                        this.oneOrder.forEach(element => {
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
            this.loading =1;
            this.$http.post('/api/finishOrder_paypal_quote',
                {   
                    custno:JSON.parse(this.storage.getItem('user')).id,
                    sono:this.so,
                }
                ).then(response=>{
                this.loading = 0;
                if (response.data.result) {
                    this.oneOrder.forEach(element => {
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
    mounted(){
        var that = this;
        this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
        this.billing = JSON.parse(this.storage.getItem('billing'));
        this.id = JSON.parse(this.storage.getItem('user')).id;
        
        this.$http.get('/api/oneOrder', { params: { 'so': this.so,'id': this.id } }).then(response => {
            
        if (response.data.status=='invalid') {
            this.empty=true;
            this.$message(
                {
                    message:'Order not found.',
                    type:'error',
                }
            );
            // this.$router.push({name:'userHome'});
        }else{
            this.oneOrder = response.data.oneOrder;
            this.somast = response.data.somast;
            this.total = this.somast.shipping + this.somast.tax +this.somast.subtotal;
            this.status = response.data.status;
            this.show = true;
            this.shippingDays = this.somast.shippingdays;
            this.address = response.data.address;

            /**  set my items */
            this.myItems = [
                {
                    "name": "Tax",
                    "description": "Tax.",
                    "quantity": "1",
                    "price": response.data.somast.tax,
                    "currency": "CAD"
                },
                {
                    "name": "Shipping",
                    "description": "Shipping Fee.",
                    "quantity": "1",
                    "price": response.data.somast.shipping,
                    "currency": "CAD"
                }
                
            ];
            
            this.oneOrder.forEach(element => {
                
                var i = {
                    "name": element.item,
                    "description": element.descrip,
                    "quantity":element.qty,
                    "price": element.price,
                    "currency": "CAD"
                };
                this.myItems.unshift(i);
                
            });
            
        }
        
      },function(){
          this.empty=true;
      });


       
        this.loading=0;

        

        
    }


}
</script>

<style>
    .addessLabel{
        text-transform: uppercase;
    }
.edit_title{
        background-color: black;
        color: white;
        font-weight: bold;
        padding: 10px 30px;
        border-radius: 10px;
        margin-bottom:20px;
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
</style>

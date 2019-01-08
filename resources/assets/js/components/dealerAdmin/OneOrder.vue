<template>
<div v-loading='loading'  
		element-loading-text="Calculating ...">
    <div v-if="empty">
        <div class="alert alert-danger">
            Order not found. 
        </div>
    </div>
    <div v-if="!empty">
        
        <div class="edit_title" >
            <span>Order Number : {{so}} </span><span v-if="show">Order Date : {{ (somast.date_order).substring(0,10) }}  </span>
        </div>

        <el-steps :active="3" finish-status="success">
            <el-step title="Step 1"></el-step>
            <el-step title="Step 2"></el-step>
            <el-step title="Step 3"></el-step>
            
        </el-steps>
        <div class='row'>
            <div class="col-xs-6">
                <h1><i>GOLDEN LEAF AUTOMOTIVE</i></h1>
                <h4>
                    170 ZENWAY BLVD UNIT#2<br>
                    WOODBRIDGE, ONTARIO L4H 2Y7<br>
                    TELEPHONE 905/850-3433<br>
                    GST/HST # 864767512RT0001
                </h4>
            </div>

            <div class="col-xs-6">
                <h1><b style='font-size:80%'>SALES ORDER {{somast.order_num}}</b></h1>
                <h4>
                    <br>
                    <br>
                    <br>
                    <br>
                </h4>
            </div>
        </div>
        
        <div>
            <div class="col-xs-6">
                <el-card class="box-card" >
                            <h4>Bill To</h4>
                            <h4>{{dealerInfo.company}} <br><br>{{dealerInfo.address1}},  {{dealerInfo.city}}, {{dealerInfo.zip}}<br>{{dealerInfo.terr}}, {{dealerInfo.country}}<br>{{dealerInfo.phone}}</h4>
                    </el-card>
            </div>
            <div class="col-xs-6">
                <div  v-if="address==''" >
                    
                    <el-card class="box-card" >
                            <h4>Ship To</h4>
                            <h4>{{dealerInfo.company}} <br> <br>{{dealerInfo.address1}},  {{dealerInfo.city}}, {{dealerInfo.zip}}<br>{{dealerInfo.terr}}, {{dealerInfo.country}}<br>{{dealerInfo.phone}}</h4>
                    </el-card>
                </div>

                <div v-if="address!=''" >
                    <el-card class="box-card" >
                            <h4>Ship To</h4>
                            <h4>{{address.company}}<br> <br>
                            {{address.address}},  {{address.city}}, {{address.postalcode}}<br>
                            {{address.province}}, {{address.country}}<br>{{address.tel}}</h4>
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
        <!-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Dealer Account</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <th>{{somast.account}}</th>
                    <th>${{somast.subtotal|decimal}}</th>
                    <th>${{somast.tax|decimal}}</th>
                    <th>${{somast.subtotal + somast.tax |decimal}}</th>
                </tr>
            </thead>
        </table> -->
        <h4>NOTES: {{somast.notes}}</h4>
        <table style='width:100%;font-size:18px;'>
                
                <tr class='row'>
                    <td style='width:90%' class='text-right'>Subtotal:</td>
                    <td style='width:10%' class='text-right'>${{somast.subtotal|decimal}}</td>
                    
                </tr>
                <tr class='row'>
                    <td style='width:90%' class='text-right'>Tax:</td>
                    <td style='width:10%' class='text-right'>${{somast.tax|decimal}}</td>
                    
                </tr>
                <tr class='row'>
                    <th style='width:90%' class='text-right'>Total:</th>
                    <th style='width:10%' class='text-right'>${{(somast.tax + somast.subtotal)|decimal}}</th>
                    
                </tr>
               
        </table>
        <div class="text-right" style='margin-top:30px'>
            <!-- <el-button type='success' @click='$router.push({path:"/CustomerInfo/OrderHistory"})'>Print Order</el-button> -->
            
            <el-button type='primary' @click='$router.push({name:"OrderHistory_dealer"})'>History Order</el-button>
            <el-button type='primary' @click='$router.push({path:"/allProducts"})'>Continue Shopping</el-button>        
        </div>  
    </div>
</div>        
</template>

<script>
export default {
    data(){
        return {
            so:this.$route.params.order_num,
            loading:1,
            storage:window.localStorage,
            account:0,
            oneOrder:[],
            somast:[],
            empty:false,
            show:false,
            address:[],
            dealerInfo:[],
        }
    },
    computed:{
        statusCode(){
            var status = '';
            switch (this.somast.sales_status) {
                case'':
                    status = 'Payment Failed';
                    break;
                case 1:
                    status = 'Payment Success';
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
    mounted(){
        this.account = JSON.parse(this.storage.getItem('user')).account;
        this.$http.get('/api/oneOrder_dealer_finish', { params: { 'so': this.so,'account': this.account } }).then(response => {
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
            this.status = response.data.status;
            this.show = true;
            this.address = response.data.address;
            this.dealerInfo = response.data.dealerInfo;

            this.oneOrder.forEach(element => {
                this.storage.removeItem(element.item);
            });
            this.loading=0;
        }
        
      },function(){
          this.empty=true;
      });
    }


}
</script>

<style>

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
</style>

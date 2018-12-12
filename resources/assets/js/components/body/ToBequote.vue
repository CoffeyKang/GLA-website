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
            <span>Order Number : {{so}} Panding Quotation</span><span v-if="show">Order Date : {{ (somast.date_order).substring(0,10) }}  </span>
        </div>

        <el-steps :active="3" finish-status="success">
            <el-step title="Step 1"></el-step>
            <el-step title="Step 2"></el-step>
            <el-step title="Step 3"></el-step>
            <el-step title="Step 4"></el-step>
        </el-steps>
        <div>
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
                <h1><b style='font-size:80%'>Pending Order Number: {{somast.order_num}}</b></h1>
                <h4><br><br><br><br>
                    
                </h4>
            </div>
        </div>
        
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
        <!-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Shipping</th>
                    <th>Estimate Shipping Days</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <th>${{somast.shipping}}</th>
                    <th>{{somast.shippingdays}}</th>
                    <th>${{somast.subtotal|decimal}}</th>
                    <th>${{somast.tax|decimal}}</th>
                    <th>{{statusCode}}</th>
                </tr>
            </thead>
        </table> -->

        <table style='width:100%;font-size:18px;'>
                <tr class='row' v-if="somast.shipping>0">
                    <td style='width:90%' class='text-right'>Shipping:</td>
                    <td style='width:10%' class='text-right'>${{somast.shipping}}</td>
                </tr>

                <tr class='row' v-if="somast.shipping==0">
                    <td style='width:90%' class='text-right'>Shipping:</td>
                    <td style='width:10%' class='text-right'>TBD</td>
                </tr>
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
                    <th style='width:10%' class='text-right'>${{(somast.tax + somast.subtotal + somast.shipping)|decimal}}</th></th>
                    
                </tr>
               
        </table>
        <div class="text-right" style='margin-bottom:10px;'>
            <el-button type='default' @click='$router.push({path:"/CustomerInfo/OrderHistory"})'>OrderHistory</el-button>
            <el-button type='primary' @click='$router.push({path:"/allProducts"})'>Continue Shopping</el-button>        
        </div>  
    </div>
</div>        
</template>

<script>
export default {
    data(){
        return {
            so:this.$route.params.sono,
            storage:window.localStorage,
            account:0,
            oneOrder:[],
            somast:[],
            empty:false,
            show:false,
            address:[],
            userInfo:[],
            billing:[],
            loading:1,
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
        downPDF(sono){
				window.open('/PDF/salesOrder/'+sono+'.pdf');
			},
    },
    mounted(){
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
            this.status = response.data.status;
            this.show = true;
            this.address = response.data.address;
            this.loading = 0;
            this.oneOrder.forEach(element => {
                this.storage.removeItem(element.item);
            });
        }
        
      },function(){
          this.empty=true;
      });
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
</style>

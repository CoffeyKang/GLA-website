<template>
    <div>
        <div class="edit_title">
            Pending Order
        </div>
        
        <table class="table table-striped table-hover" style='margin-top:20px;'>
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Order Number</th>
                    <th>Currency</th>
                    <th>Order Status</th>
                    <th style='width:100px;'>track_num</th>
                    <th class='text-right'>Shipping</th>
                    <th class='text-right'>Tax</th>
                    <th class='text-right'>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in pending.slice(from,end)" :key="item.sales_serial" @click='HistoryDetails(item.order_num)'>
                    <td>{{item.date_order.substring(0,10)}}</td>
                    <td>{{item.order_num}}</td>
                    <th>{{item.currency}}</th>
                    <th>
                        <span v-if="item.sales_status==0">Unpaid
                        </span>
                        <span v-if="item.sales_status==1">Payment Success
                        </span>
                        <span v-if="item.sales_status==3">Pending for Quote
                        </span>
                        <span v-if="item.sales_status==5">Pending for Reply
                        </span>
                        <span v-if="item.sales_status==7">Under Process
                        </span>
                        <span v-if="item.sales_status==9">Shipped
                        </span>
                    </th>
                    <td>{{item.track_num}}</td>
                    <td class='text-right'>$ {{parseFloat(item.shipping).toFixed(2)}}</td>
                     <td class='text-right'>$ {{parseFloat(item.tax).toFixed(2)}}</td>
                    <td class='text-right'>$ {{parseFloat(item.subtotal).toFixed(2)}}</td>
                </tr>
            </tbody>
        </table>
        
        <div class='text-center'>
            <el-button icon="el-icon-d-arrow-left" circle @click='previousPage()' v-if="current>1"></el-button>
            <span class='current'>{{current}}</span>
            <el-button icon="el-icon-d-arrow-right" circle @click='nextPage()'  v-if="current<(pending.length/10)"></el-button>
        </div>
    </div>
    
</template>

<script>
export default {
    data(){
        return {
            orderHistory:[],
            current:1,
            pending:[],
            
        }
    },
    mounted(){
        this.dealerOrderHistory();
        
        
    },
    methods:{
        HistoryDetails(order_num){
            this.$router.push({ name: 'OneOrder_dealer', params: { order_num: order_num }});
            
        },

        previousPage(){
             this.current-=1;
        },

        nextPage(){
            this.current+=1;
        },
    },
    computed:{
        from(){
            return 10*(this.current -1);
        },
        end(){
            return 10*this.current;
        }
    }
}
</script>

<style>
    .current{
        padding: 0 30px;
    }
    .edit_title{
        background-color: black;
        color: white;
        font-weight: bold;
        padding: 10px 0 10px 30px;
        border-radius: 10px;
    }

</style>

<template>
<div>
   
    <div v-if="empty">
        <div class="alert alert-danger">
            Order not found. 
        </div>
    </div>
    <div v-if="!empty">

        <div class="edit_title" >
            <span>Order Number : {{so}}</span><span v-if="show">Order Date : {{ (somast.date_order).substring(0,10) }} </span>
        </div>
        
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                <th>Item</th>
                <th>QTY</th>
                <th>Compatiable Make</th>
                <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in oneOrder" :key="item.order_serial">
                    <td>{{item.item}}</td>
                    <td>{{item.qty}}</td>
                    <th>{{item.make.replace('_ca','').toUpperCase()}}</th>
                    <td >$ {{item.price.toFixed(2)}}</td>
                </tr>
            </tbody>
        </table>
        <div class="panel" v-if="somast.notes.length>=1">
            <b>NOTES: </b>{{somast.notes}}
        </div>
        <div class="text-right">
            <el-button type='primary' @click='$router.push({name:"OrderHistory_dealer"})'>Back</el-button>    
        </div>  
    </div>
</div>        
</template>

<script>
export default {
    data(){
        return {
            so:this.$route.params.order_num,
            storage:window.localStorage,
            account:0,
            oneOrder:[],
            somast:[],
            empty:false,
            show:false,

        }
    },

    mounted(){
        this.account = JSON.parse(this.storage.getItem('user')).account;
        this.$http.get('/api/oneOrder_dealer', { params: { 'so': this.so,'account': this.account } }).then(response => {
        if (response.data.status=='invalid') {
            this.empty=true;
            this.$message(
                {
                    message:'Order not found.',
                    type:'error',
                }
            );
            this.$router.push({name:'userHome'});
        }else{
            this.oneOrder = response.data.oneOrder;
            this.somast = response.data.somast;
            this.status = response.data.status;
            this.show = true;
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

<template>
    
    <div>
        <h3>Order Number : {{so}}</h3> 
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                <th>Item</th>
                <th>QTY</th>
                <th>Make</th>
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
        <div class="text-right">
            <el-button type='primary' @click='$router.push({name:"OrderHistory"})'>Back</el-button>    
        </div>  
    </div>
        
</template>

<script>
export default {
    data(){
        return {
            so:this.$route.params.order_num,
            storage:window.localStorage,
            id:0,
            oneOrder:[],
            somast:[],
            

        }
    },

    mounted(){
        this.id = JSON.parse(this.storage.getItem('user')).id;
        this.$http.get('/api/oneOrder', { params: { 'so': this.so,'id': this.id } }).then(response => {
        this.oneOrder = response.data.oneOrder;
        this.somast = response.data.somast;
        this.status = response.data.status;
        
      });
    }


}
</script>

<style>


</style>

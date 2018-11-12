<template>
    <div>
        

        <div class="edit_title">
            Dealer Arae
        </div>
        <!-- <div style='margin-top:20px;'>
            <el-card class="box-card">
                <div class="clearfix" slot="header">
                    Latest News
                </div>
                <div class="text">
                    Once the spring thaw gives the way to soiling summer heat, I fill in love with swimming.
                </div>
            </el-card>
        </div> -->

        <div class='details'>
            <div style='width:48%;'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Account Details
                    </div>
                    <div class="text" style='min-height:120px;'>
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Account:</div></el-col>
                            <el-col :span="16"><div class="grid-content">{{user.account}}</div></el-col>
                        </el-row>
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Company:</div></el-col>
                            <el-col :span="16"><div class="grid-content">{{fullname}}</div></el-col>
                        </el-row>
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Email:</div></el-col>
                            <el-col :span="16"><div class="grid-content">{{ userInfo.email }}</div></el-col>
                        </el-row>
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Address:</div></el-col>
                            <el-col :span="16"><div class="grid-content">{{ address }}</div></el-col>
                        </el-row>     
                    </div>
                </el-card>
            </div>

            <div style='width:48%;'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Order Status
                    </div>
                    <div class="text" style='min-height:120px;' >
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Recent Order</div></el-col>
                            <el-col :span="16">
                                <div class="grid-content" v-if="orderHistory.length>=1">
                                    {{ orderHistory[0].order_num }}, {{ (orderHistory[0].date_order).substring(0,10) }}
                                </div>

                                <div class="grid-content" v-if="orderHistory.length<1">
                                    --
                                </div>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20" justify="center" >
                            <el-col :span="8"><div class="grid-content">Order History</div></el-col>
                            <el-col :span="16">
                                <div class="grid-content" v-if="orderHistory.length>=1">
                                    {{ orderHistory.length }}
                                </div>

                                <div class="grid-content" v-if="orderHistory.length<1">
                                    --
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </el-card>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    data(){
        return {
            storage : window.localStorage,
            userInfo:{},
            user:{},
            orderHistory:[],
        }
    },

    mounted(){
        
        this.user = JSON.parse(this.storage.getItem('user'));
        this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
        this.$http.get('/api/dealerInfo/'+this.user.account).then((response)=>{
        });

        this.dealerOrderHistory();
        
    },

    computed: {
        fullname: function () {
            return this.userInfo.company; 
        },
        
        address:function(){
             return this.userInfo.address1 + ' ' + this.userInfo.city + ' ' +this.userInfo.state + ' ' +
             this.userInfo.country + ' ' +this.userInfo.zip;
        }
  }

}
</script>

<style>
    .details{
        margin-top: 30px;
        display: flex;
        justify-content: space-between;

    }
    .el-col{
        margin-bottom: 10px;
    }
    .edit_title{
        background-color: black;
        color: white;
        font-weight: bold;
        padding: 10px 0 10px 30px;
        border-radius: 10px;
    }
    
    

</style>    

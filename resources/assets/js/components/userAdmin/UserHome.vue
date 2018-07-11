<template>
    <div>
        <div>
            <el-card class="box-card">
                <div class="clearfix" slot="header">
                    Latest News
                </div>
                <div class="text">
                    Once the spring thaw gives the way to soiling summer heat, I fill in love with swimming.
                </div>
            </el-card>
        </div>

        <div class='details'>
            <div style='width:48%;'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Account Details
                    </div>
                    <div class="text" style='min-height:120px;'>
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Name:</div></el-col>
                            <el-col :span="16"><div class="grid-content">{{fullname}}</div></el-col>
                        </el-row>
                        <el-row :gutter="20" justify="center">
                            <el-col :span="8"><div class="grid-content">Email:</div></el-col>
                            <el-col :span="16"><div class="grid-content">{{ user.email }}</div></el-col>
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
                                    {{ orderHistory[0].order_num }}, {{ orderHistory[0].date_order }}
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
        this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
        this.user = JSON.parse(this.storage.getItem('user'));
        this.customerOrderHistory();
        
    },

    computed: {
        fullname: function () {
            return this.userInfo.m_forename + ' ' + this.userInfo.m_surname; 
        },
        
        address:function(){
             return this.userInfo.m_address + ' ' + this.userInfo.m_city + ' ' +this.userInfo.m_state + ' ' +
             this.userInfo.m_country + ' ' +this.userInfo.m_zipcode;
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
    
    

</style>    

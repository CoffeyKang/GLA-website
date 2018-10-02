<template>
    <div class="container" v-loading='loading'  
		element-loading-text="Calculating ..."
        
	>
        <h3>Confirm Order</h3>
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
            <div class='shipingTo'>
                    <div class='col-xs-12' v-if="addressID==0">
                        <h4>Shipping To</h4>
                        <el-card class="box-card" >
                                <h5><b>{{userInfo.m_forename}} {{userInfo.m_surname}}</b> <br> <br>
                                {{userInfo.m_address}},  {{userInfo.m_city}}, {{userInfo.m_zipcode}}<br>
                                {{userInfo.m_state}}, {{userInfo.m_country}}</h5>
                        </el-card>
                    </div>

                    <div class='col-xs-12' v-if="addressID!=0">
                        <h4>Shipping To</h4>
                        <el-card class="box-card" >
                                <h5><b>{{address.forename}} {{address.surname}}</b> <br> <br>
                                {{address.address}}, {{address.city}}, {{address.zipcode}}<br>
                                {{address.state}}, {{address.country}}</h5>
                        </el-card>
                    </div>
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
                            <span>SUBTOTAL:</span><span>${{ subtotal }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>SHIPPING:</span><span>${{ shipping }}</span>
                            
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>HST:</span><span>${{ hst }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>TOTAL:</span><span>${{ total.toFixed(2) }}</span>
                            
                        </div>
                    </div>

                    <div class=' summary_list text-center'>
                        <h5>Estimate Shipping Date : {{ shippingDays }} Days</h5>
                    </div>

                    <div class=' summary_list text-center'>
                        <button class='mybtn btn btn-warning' @click='$router.push("shoppingCart")'>Edit Order</button>
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
            items:[],
            qtys:[],
            otherAddress:false,
            storage:window.localStorage,
            carts:this.$route.params.carts,
            subtotal:this.$route.params.subtotal,
            hst:this.$route.params.hst,
            quotes:[],
            shippingOPT:this.$route.params.shippingOPT,
            shipping:this.$route.params.shipping,
            userInfo:this.$route.params.userInfo,
            loading:1,
            addressBook:this.$route.params.addressBook,
            addressID:this.$route.params.addressID,
            address:[],
        }
    },
        computed:{
            total:function(){
                return parseFloat(this.subtotal) + parseFloat(this.hst) + parseFloat(this.shipping);
            },

            shippingDays:function(){
                if (this.shippingOPT==1) {
                    return this.$route.params.groundDays;
                }else{
                    return this.$route.params.expressDay;
                }
            }
            
        },
        mounted(){
            // determin if user has login
			if(this.storage.getItem('user')){
				// have to validate the user name and password once more here
                var userData = JSON.parse(this.storage.getItem('user'));
                
                /** check again */
                this.loading = 0;
			}else{
				this.$store.commit('changeLoginDirect','home');
				this.$router.push('Login');
            };

            if (this.addressID!=0) {
                this.$http.get('/api/address/'+this.addressID).then(response => {
                    console.log(response);
                    if (response.address!='notFound') {
                        this.address = response.address;
                    }else{
                        this.addressID=0;
                    }
                    
                }, response => {
                    
                })
            };
        },
        methods:{
            
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


<template>
    <div class="container" v-loading='loading'  
		element-loading-text="Calculating ..."
        
	>
        <h3>Confimr Order</h3>
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
                    <div class='col-xs-12' v-if="!otherAddress">
                        <h4>Shipping To</h4>
                        <el-card class="box-card" >
                                <h5><b>{{userInfo.m_forename}} {{userInfo.m_surname}}</b> <br> <br>
                                {{userInfo.m_address}},  {{userInfo.m_city}}, {{userInfo.m_zipcode}}<br>
                                {{userInfo.m_state}}, {{userInfo.m_country}}</h5>
                        </el-card>
                    </div>

                    <div class='col-xs-12' v-if="otherAddress">
                        <h4>Shipping To</h4>
                        <el-card class="box-card" >
                                <h5><b>{{userInfo.forename}} {{userInfo.surname}}</b> <br> <br>
                                {{userInfo.address}},  {{userInfo.city}}, {{userInfo.zipcode}}<br>
                                {{userInfo.state}}, {{userInfo.country}}</h5>
                        </el-card>
                    </div>


                    <div class='col-xs-12'  style='margin-top:20px;'>
                        <h4>Shipping To another address</h4>
                        <el-select v-model="selectAdd" placeholder="Shipping To ...">
                            <el-option
                            v-for="item in addressBook"
                            :key="item.id"
                            :label="item.forename + ' '+ item.surname "
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                <div class='addressBook col-xs-12' >
                    <div class='address' v-for="address in addressBook" :key="address.id" v-if="address.id==selectAdd">
                        <el-card class="box-card addressBox" :id="'box'+address.id" >
                                <h5><b>{{address.forename}} {{address.surname}}</b> <br> <br>
                                {{address.address}},  {{address.city}}, {{address.zipcode}}<br>
                                {{address.state}}, {{address.country}}</h5>
                                <div class='shipToAddress'>
                                    <button class=" btn btn-success text-center" @click='changeAddress(address.id)'>
                                        Deliver to address
                                    </button>
                                    <button class=" btn btn-danger text-center" @click="deleteAddress(address.id)">
                                        Delete this address
                                    </button>
                                </div>
                        </el-card>
                    </div>
                </div>

                
                
                <div class="newShipping col-xs-12" @keyup.enter='submitForm(newAdd)'>
                    <h4 >New Shipping Address</h4>
                    <el-card class="box-card" >
                        <el-form label-position="left" label-width="100px" :model="newAdd"  :rules="rules" ref='newAdd'>
                            <div class="inRow">
                                <el-form-item label="Last Name" prop='surname' component:input>
                                    <el-input v-model="newAdd.surname"></el-input>
                                </el-form-item>
                                <el-form-item label="First Name" prop='forename'>
                                    <el-input v-model="newAdd.forename"></el-input>
                                </el-form-item>
                            </div>
                            <el-form-item label="Address" prop='address'>
                                <el-input v-model="newAdd.address"></el-input>
                            </el-form-item>
                            <div class="inRow">
                                <el-form-item label="City" prop='city'>
                                    <el-input v-model="newAdd.city" placeholder="City"  ></el-input>
                                </el-form-item>

                                <el-form-item label="State" prop='state'>
                                    <el-select v-model="newAdd.state" placeholder="State">
                                        <el-option
                                        v-for="item in privince"
                                        :key="item.name"
                                        :label="item.name"
                                        :value="item.Code">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                                
                            </div>
                            <div class="inRow">
                                <el-form-item label="Zipcode" prop='zipcode'>
                                    <el-input v-model="newAdd.zipcode"></el-input>
                                </el-form-item>
                                <el-form-item label="Country" prop='country'>
                                    <el-input v-model="newAdd.country"></el-input>
                                </el-form-item>
                            </div>
                            <el-form-item label="Telphone" prop='tel'>
                                <el-input v-model="newAdd.tel"></el-input>
                            </el-form-item>

                            <el-form-item class='text-center'>
                                <el-button type="success" @click="submitForm(newAdd)">Add New Address</el-button>
                                
                            </el-form-item>
                            
                        </el-form>                
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
                            <span>SHIPPING:</span><span v-if="shippingRate=='quotable'">${{ shipping }}</span>
                            <span v-if="shippingRate!='quotable'">TBD</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>HST:</span><span>${{ hst }}</span>
                        </div>
                    </div>
                    <div class="summary_list">
                        <div class='summary_amount'>
                            <span>TOTAL:</span><span v-if="shippingRate=='quotable'">${{ total.toFixed(2) }}</span>
                            <span v-if="shippingRate!='quotable'">TBD</span>
                        </div>
                    </div>
                </div>

                <div class=" text-center" v-if="shippingRate=='quotable'">
                    <button class='mybtn btn btn-success' @click='confirm()'>Confirm Order</button>
                    <button class='mybtn btn btn-warning' @click='$router.push("shoppingCart")'>Edit Order</button>
                </div>

                <div class="text-center shippingOPT ">
                    <el-radio-group v-model="shippingOPT" v-if="shippingRate=='quotable'">
                        <el-radio :label="1">Ground Shipping, taking <b>{{parseInt(groundDay) +3}}</b> days</el-radio><br>
                        <el-radio :label="2">Express Shipping, taking <b>{{parseInt(expressDay) +1}}</b> days</el-radio>
                    </el-radio-group>
                </div>

                <div class=" text-center" v-if="shippingRate!='quotable'">
                    <button class='mybtn btn btn-success' >Get a Quote</button>
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
            carts:[],
            subtotal:0,
            hst:0,
            addressID:0,
            quotes:[],
            shippingOPT:1,
            expressDay:1,
            groundDay:1,
            shippingRate:'',
            // shipping:0,
            privince:[
                    {name:'Alberta',Code:"AB"},
                    {name:'British-Coloumbia',Code:"BC"},
                    {name:'Manitoba',Code:"MB"},
                    {name:'New-Brunswick',Code:"NB"},
                    {name:'Newfoundland and Labrador',Code:"NL"},
                    {name:'Northwest Territories',Code:"NT"},
                    {name:'Nova-Scotia',Code:"NS"},
                    {name:'Nunavut',Code:"NU"},
                    {name:'Ontario',Code:"ON"},
                    {name:'Prince-Edward Island',Code:"PE"},
                    {name:'Quebec',Code:"QC"},
                    {name:'Saskatchewan',Code:"SK"},
                    {name:'Yukon',Code:"YT"},
                ],  
            userInfo:[],
            loading:1,
            addressBook:[],
            defaultAddress:true,
            newAdd:{

            },
            selectAdd:"",
            rules:{
                surname:[
                        { required: true, message: 'Surname is required.', trigger: 'blur', max:99 }
                    ],
                    forename:[
                        { required: true, message: 'Forename is required.', trigger: 'blur', max:99 },
                    ],
                    city:[
                        { required: true, message: 'City is required.', trigger: 'blur', max:99 },
                    ],
                    state:[
                        { required: true, message: 'State is required.', trigger: 'blur', max:99 },
                    ],
                    zipcode:[
                        { required: true, message: 'Zip Code is required.', trigger: 'blur', max:99 },
                    ],
                    address:[
                        { required: true, message: 'Address is required.', trigger: 'blur', max:99 },
                    ],
                    country:[
                        { required: true, message: 'Country is required.', trigger: 'blur', max:99 },
                    ],
                    tel:[
                        {required: true, message: 'Invalid telephone number.', trigger: 'blur',  max:15,}
                    ],
            }
        }
    },
        computed:{
            total:function(){
                
                return parseFloat(this.subtotal) + parseFloat(this.hst) + parseFloat(this.shipping);

            },
            shipping:{

                get:function () {
                    if (this.shippingOPT==1) {
                        return this.quotes['ground'];
                    }else{
                        return this.quotes['express'];
                    }
                },

                set:function() {
                    
                }
                
            },

            shippingDays(){
                if (this.shippingOPT=='1') {
                    return parseInt(this.groundDay)+3;
                }else{
                    return parseInt(this.expressDay)+1;
                }
            }
        },
        mounted(){
            // determin if user has login
			if(this.storage.getItem('user')){
				// have to validate the user name and password once more here
                var userData = JSON.parse(this.storage.getItem('user'));
                /** check again */
                this.$http.get('/api/shortlist',{params:{userid:userData.id}}).then(response=>{
                    console.log(response);
                    this.carts = response.data.carts;
                    this.subtotal = response.data.subtotal.toFixed(2);
                    this.hst = response.data.tax_total.toFixed(2);
                    this.userInfo = response.data.userInfo;
                    
                    this.shippingRate = response.data.shippingRate;
                    this.quotes = response.data.quotes;
                    this.shipping = this.quotes['ground'];
                    this.groundDay = response.data.groundDay;
                    this.expressDay = response.data.expressDay;
                    this.loading = 0;
                    this.addressBook = response.data.addressBook;
                });

			}else{
				this.$store.commit('changeLoginDirect','home');
				this.$router.push('Login');
            }
        },
        methods:{
            submitForm(newAdd){
                console.log('submit form');
                this.$refs["newAdd"].validate((valid)=>{
                    if (valid){
                        // submit userDetails info        
                        var userId = this.userInfo.m_id;
                        console.log(userId);
                        this.$http.post('/api/newShippingAdd',
                            {
                                'userID':userId,
                                'data':this.newAdd,
                            }).then((response)=>{
                                this.addressBook = response.data.addressBook;
                                this.$message(
                                    {
                                        showClose:true,
                                        message:"Successfully create new shipping address",
                                        type:"success",
                                        duration:5000,
                                    }
                                );
                                this.$refs["newAdd"].resetFields();
                                window.scrollTo(0,0);
                            });
                        
                        

                    }else{
                        this.$message({
                            showClose:true,
                            message:"Error Submit",
                            type:"error",
                            duration:5000,
                        });
                        return false;
                    }
                });
            },

            deleteAddress(id){
                this.$confirm('Are you sure to delete the address.', 'Warning', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                    }).then(() => {
                        this.$http.post('/api/deleteAddress',{'id':id}).then(response=>{
                            console.log(response);
                            this.$message({
                                type: 'success',
                                message: 'Scuccessfully delete!',
                            });
                            this.addressBook = response.data.addressBook;
                            window.scrollTo(0,0);

                        });
                        
                    }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Canceled'
                    });          
                });
            },
            changeAddress(id){
                this.loading = 1;
                window.scrollTo(0,0);   
                this.$http.post('/api/changeAddress',{"id":id}).then(response=>{
                    this.subtotal = response.data.subtotal.toFixed(2);
                    this.hst = response.data.tax_total.toFixed(2);
                    this.userInfo = response.data.userInfo;
                    this.shippingRate = response.data.shippingRate;
                    this.quotes = response.data.quotes;
                    this.shipping = this.quotes['ground'];
                    this.groundDay = response.data.groundDay;
                    this.expressDay = response.data.expressDay;
                    this.addressBook = response.data.addressBook;
                    this.otherAddress = true;
                    this.addressID = response.data.addressID,
                    this.loading = 0;
                    $('.addressBox').css("border",'none');
                    $("#box"+id).css("border",'3px solid green');
                });        
            },

            confirm(){
                /** store to database */
                this.loading = 0;

                this.carts.forEach(element => {
                    this.storage.removeItem(element.item);
                });
                this.$store.commit('carts_number',0);
                this.$http.post('/api/confirmOrder',{
                        userId:this.userInfo.m_id,
                        shippingOPT:this.shippingOPT,
                        shippingFee:this.shipping,
                        shippingDays:this.shippingDays,
                        hst:this.hst,
                        subtotal:this.subtotal,
                        addressID:this.addressID,

                    }).then(response=>{
                        
                        this.$router.push({name:"ConfirmOrder", 
                            params:{
                                sono:response.data.sono,
                                userId:this.userInfo.m_id,
                            }
                        });
                })
                
            },
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


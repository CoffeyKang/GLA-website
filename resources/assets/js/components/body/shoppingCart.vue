<template>
    <div class="container">
        <h3>Shopping Cart</h3>
        <el-steps :active="1" finish-status="success">
            <el-step title="Step 1"></el-step>
            <el-step title="Step 2"></el-step>
            <el-step title="Step 3"></el-step>
            <el-step title="Step 4"></el-step>
        </el-steps>
        <div class="container-fluid body">
        
            <div class="col-xs-12 col-sm-8" style='padding:0;'>
                <div class="container-fulid oneItem" v-for="item in carts" :key="item.item" v-if="carts.length>=1">
                    <div class='singleItem'>
                        <div class="itemImg" >
                            <div id="itemImg" :style="{ backgroundImage: 'url(' + item.img_path + ')' }">
                                
                            </div>
                        </div>
                        <div class="itemDetails">
                            <div class="desc">
                                <span class='title'>{{item.descrip}}</span>
                                <span class='info'>Product No: {{item.item}}</span>
                                <span class='info'>Year Fit: {{item.year_from}} -- {{item.year_end}}</span>
                                <span class='info'>Make: {{item.make}}</span>
                            </div>
                            
                            <div class="qty">
                                <b style='width:50px; height:28px;line-height:28px;'> QTY: </b>
                                
                                <input type="number" :value="parseInt(storage.getItem(item.item))"
                                    style='width:50px;' min="0" :max="parseInt(item.onhand)" :id="item.item" 
                                    v-if="user.level!=2">

                                <input type="number" :value="parseInt(storage.getItem(item.item))"
                                    style='width:50px;' min="0"  :id="item.item" 
                                    v-if="user.level==2">
                                <div style='height:28px; padding-left:15px;' class='update_link'>
                                    <button class='btn btn-link' @click="updateCart(item)">Update</button>
                                </div>
                                
                            </div>
                            <div class="instock" v-if="user.level!=2">
                                In-stock: {{item.onhand}}
                            </div>
                        </div>
                        <div class="item_action text-right">
                            <div class="closure ">
                                <span class="glyphicon glyphicon-remove" @click="removeFromCart(item)"></span>
                            </div>
                            <div class="toWish" @click='removeToWish(item)'>
                                Add to Wishlist <span class="glyphicon glyphicon-heart-empty"></span>
                            </div>
                            <div class="price" v-if="item.onhand -item.aloc > item.orderpt && disc">
                                <span>
                                    SALE: CAD ${{item.pricel |discount10 |decimal}}<br>
                                    <span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel)/$store.state.exchange)|discount10 |decimal }}</span>
                                </span>
                                <span>
                                    TOTAL: CAD ${{(item.pricel) * parseInt(storage.getItem(item.item)) |discount10 |decimal}}<br>
                                    <span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel) * parseInt(storage.getItem(item.item))/$store.state.exchange)|discount10 |decimal }}</span>
                                </span>
                            </div>

                            <div class="price" v-if="item.onhand-item.aloc <= item.orderpt || !disc">
                                <span>
                                    PRICE: CAD ${{item.pricel |decimal }}<br>
                                    <span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel)/$store.state.exchange).toFixed(2) }}</span>
                                </span>
                                <span>
                                    TOTAL: CAD ${{(item.pricel) * parseInt(storage.getItem(item.item)) |decimal}}<br>
                                    <span v-if='usdPrice' class='usdPrice'>USD ${{ ((item.pricel) * parseInt(storage.getItem(item.item))/$store.state.exchange).toFixed(2) }}</span>
                                </span>
                            </div>

                            
                        </div>
                    </div>
                </div>
                <div class="container-fulid oneItem alert alert-warning" v-if="carts.length<1" style='border:0'>
                    <h5>Your Shopping Cart is empty.</h5>
                    
                </div>
            </div>
            <div class=" col-xs-12 col-sm-4 mobile_total" style='padding-right:0;padding-top:15px; padding-left:30px;'>
                <div class="summary" >
                    <div class="summary_title">
                        ORDER SUMMARY
                    </div>
                    <div class="summary_details">
                        <div class="summary_list">
                            <div class='summary_amount'>
                                <span>SUBTOTAL:</span><span class='text-right'>CAD ${{ subtotal|decimal }}<br>
                                    <span v-if='usdPrice' class='usdPrice '>USD ${{ (subtotal/$store.state.exchange).toFixed(2) }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="summary_list" v-if="!ifDealer()">
                            <div class='summary_amount'>
                                <span>SHIPPING:</span><span>${{ shipping }}</span>
                            </div>
                        </div>
                        <div class="summary_list">
                            <div class='summary_amount'>
                                <span>TAX:</span><span>${{ hst }}</span>
                            </div>
                        </div>
                        <div class="summary_list">
                            <div class='summary_amount text-right'>
                                <span>TOTAL:</span><span class='text-right'>CAD ${{ total }}<br>
                                <span v-if='usdPrice' class='usdPrice'>USD ${{ (total/$store.state.exchange).toFixed(2) }}</span></span>
                                
                            </div>
                        </div>
                    </div>

                    <div class="processBTN text-center">
                        <button class='mybtn btn btn-success' @click='checkOut()' v-if="carts.length>=1&& !isDealer">Proceed To
                        Check Out</button>
                    
                    </div>
                        

                    <div class="processBTN text-center" style='margin-top:10px'>
                        
                        <button class='mybtn btn btn-warning' @click='continueShopping()' v-if="carts.length>=1&& !isDealer">Continue Shopping</button>
                    </div>

                    <div class="processBTN text-center ">
                        <button class='mybtn btn btn-success' @click='dealerCheckOut()' v-if="carts.length>=1&& isDealer">Proceed To
                        Check Out</button>
                        
                    </div>

                    <div class="processBTN text-center" style='margin-top:10px'>
                        
                        <button class='mybtn btn btn-warning' @click='continueShopping()' v-if="carts.length>=1&& isDealer">Continue Shopping</button>
                        
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
            storage:window.localStorage,
            carts:[],
            subtotal:0,
            shipping:"-",
            hst:"-",
            user:{},
            isDealer:false,
            disc:true,
           

            // total:this.subtotal,
            
            }
        },
        computed:{
            total:function(){
                return this.subtotal.toFixed(2);
            },
            usdPrice:function(){return this.$store.state.usdPrice},
        },

        filters:{
            decimal:function(value){
                if (!isNaN(value)) {
                    return value.toFixed(2)
                }else{
                    return value;
                }
            },

            discount10(price) {
				return (price * 0.9);
			}
        },
        mounted(){
            this.reloadElement();



            if (this.storage.getItem('user')) {
                this.user = JSON.parse(this.storage.getItem('user'));
                let cust_id = this.user.id;

                if (this.user.level==2) {
                    this.isDealer = true;
                    var url = 'getShortlist_dealer';
                }else{
                    this.isDealer = false;
                    var url = 'getShortlist';
                }

                this.$http.get('/api/'+url +'/'+cust_id).then((response)=>{
                    let oldShortlist = response.data.oldShortlist;
                    
                    oldShortlist.forEach(element => {
                        let item = element.item;
                        let quantity = element.qty;
                        if (window.localStorage.getItem(item)) {
                            // var qty = parseInt(window.localStorage.getItem(item)) + quantity;
                            // window.localStorage.setItem(item,qty);
                        }else{
                            window.localStorage.setItem(item,quantity);
                            
                            var newNumber = this.carts_number+1;
                            
                            this.$store.commit('carts_number',newNumber);

                        }


                    });

                    
                    

                    
                });

                this.$http.get('/api/deleteShortlist/'+cust_id).then((response=>{
                    if (response.data.deleteOldShortlist=='deletedOld') {
                        // 'shortlist has been delete');
                    }else{

                    }
                }));
            }else{
            }
            // this.$http.get('/api/getShortlist/'+)
            

            if (this.ifDealer()) {
                this.disc = false;
            }else{
                this.disc =  true;
            }
            },
            
        methods:{
            reloadElement(){
                var type = JSON.parse(this.storage.getItem('user')).level;

                // get items # from localstorage 
                for (let i = 0; i < this.storage.length; i++) {
                    this.items.push(this.storage.key(i));
                };
                var d = this.items;
                this.$http.post('api/getItems_carts',{data:d},[method=>"POST"]).then(response => {
                    this.carts = response.data.carts;
                    this.$store.commit('carts_number',this.carts.length);
                    this.subtotal = 0;                
                    this.carts.forEach(element => {
                        
                        element.pricel = this.Dealerprice(element);
                        let short_num = parseInt(this.storage.getItem(element.item));
                        if ( short_num >element.onhand && type !=2) {
                            this.storage.setItem(element.item, element.onhand);
                        }
                        if (this.ifDealer()) {
                            this.subtotal += (element.pricel) * parseInt(this.storage.getItem(element.item));
                        }else{
                            if (element.onhand - element.aloc > element.orderpt) {
                                this.subtotal += (element.pricel)*0.9 * parseInt(this.storage.getItem(element.item));
                            }else{
                                this.subtotal += (element.pricel) * parseInt(this.storage.getItem(element.item));

                            }
                        }
                    });
                        
                }, response => {
                    // error 
                });
            },
            
            removeFromCart(item){
                this.$confirm('Are you sure to delete the item from shopping cart.', 'Warning', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                    }).then(() => {
                        this.items = [];
                        this.storage.removeItem(item.item);
                        this.reloadElement();
                        this.$message({
                            type: 'success',
                            message: 'Scuccessfully delete!',
                        });
                    }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Canceled'
                    });          
                });
            },

            updateCart(item){
                var value = $("#"+item.item+"").val();

                if (value==0) {
                    this.removeFromCart(item);
                    return false;
                }
                if (value>item.onhand && this.user.level!=2) {
                    
                    this.$alert('The quantity you request exceeds our stock.', 'Warning', {
						confirmButtonText: 'OK',
					});
                    
                }else{
                    this.storage.removeItem(item.item);
                    console.log(value);
                    this.storage.setItem(item.item,value);
                    this.items = [];
                    this.reloadElement();  
                    this.$message({
                        type: 'success',
                        message: 'Update Successful.'
                    });        
                }
                
                
            },
            removeToWish(item){
                this.items = [];
                this.storage.removeItem(item.item);
                // get items # from localstorage 
                this.reloadElement();
                this.addToWishlist(item.item);
            },
            
            dealerCheckOut(){
                var user = JSON.parse(this.storage.getItem("user"));
                var userInfo = JSON.parse(this.storage.getItem("userInfo"));
                if (user&&userInfo) {
                    
                    this.$http.post('api/checkoutDealer',{storage:this.storage, userID:user.id},[method=>"POST"]).then(response => {

                        
                        if (response.data.status=="Success") {
                        this.$router.push('/dealer_checkout');
                        }else if (response.data.status=='noDetails') {
                            this.$router.push({path:'customerInfo'});
                        } 
                    }, response => {
                        // error 
                    });
                }else{

                    /** require to login and then turn back to shoppingg cart */
                    this.$store.commit('changeLoginDirect','shoppingCart');
				    this.$router.push({path:'customerInfo'});
                    
                }

                return false;    
            },
            checkOut(){
                
                /** check if the client has logged in or not. if not, checkout requirs to login. */
                var user = JSON.parse(this.storage.getItem("user"));
                var userInfo = JSON.parse(this.storage.getItem("userInfo"));

                if (user&&userInfo) {
                    
                    this.$http.post('api/checkout',{storage:this.storage, userID:user.id},[method=>"POST"]).then(response => {

                        
                        if (response.data.status=="Success") {
                            this.$router.push('/checkout');
                        }else if (response.data.status=='noDetails') {
                            this.$router.push({path:'customerInfo'});
                        } 
                    }, response => {
                        // error 
                    });
                }else{

                    /** require to login and then turn back to shoppingg cart */
                    this.$store.commit('changeLoginDirect','shoppingCart');
				    this.$router.push({path:'customerInfo'});
                    
                }

                return false;

                
                
            },

            continueShopping(){
                this.$router.push({path:'allProducts'});
               
            }

            
        },
        watch:{
            
        }
    

}
</script>
<style scoped>
    .body{
        margin-bottom: 35px;
    }
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
        width: 50%;
        padding: 30px;
        height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .item_action{
        width: 40%;
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
        justify-content: space-between;
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
        min-height: 70px;

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
        min-height: 70px;
    }
    .mybtn{
       font-size: 16px;
       width: 190px;
    }
    .fakeLink{
        cursor: pointer;    
    }

    @media screen and (max-width: 768px){
        .mobile_total{
            padding: 0 !important;
        }

        .singleItem{
            display: flex;
            flex-direction: column;
        }

        .itemImg{
            width: 100%;
            height: 150px;
        }
        #itemImg{
            margin-top: 30px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height: 150px;
        }

        .itemDetails{
            width: 100%;
            padding: 30px;
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .item_action{
            width: 100%;
            padding: 30px;
            height: 200px;
        }

        
    }
    
</style>

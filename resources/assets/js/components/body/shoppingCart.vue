<template>
    <div class="container">
        <h3>Shopping Carts</h3>
        <div class="col-sm-8" style='padding:0;'>
            <div class="container-fulid oneItem" v-for="item in carts" :key="item.item" >
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
                                style='width:50px;' min="0" :max="parseInt(item.onhand)" :id="item.item">
                            <div style='height:28px; padding-left:15px;' class='update_link'>
                                <button class='btn btn-link' @click="updateCart(item)">Update</button>
                            </div>
                            
                            
                        </div>
                        <div class="instock">
                            In-stock: {{item.onhand}}
                        </div>
                    </div>
                    <div class="item_action text-right">
                        <div class="closure ">
                            <span class="glyphicon glyphicon-remove" @click="removeFromCart(item.item)"></span>
                        </div>
                        <div class="toWish">
                            Add to Wishlist <span class="glyphicon glyphicon-heart-empty"></span>

                        </div>
                        <div class="price">
                            <span>
                                PRICE: $ {{item.pricel}}
                            </span>
                            <span>
                                TOTAL: $ {{(item.pricel) * parseInt(storage.getItem(item.item))}}
                            </span>
                        </div>
                    </div>
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
                            <span>TOTAL:</span><span>${{ total }}</span>
                        </div>
                    </div>
                </div>

                <div class="processBTN text-center">
                    <button class='mybtn'>Proceed To<br>
                    Check Out</button>
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
            total:'-',
            
            }
        },
        computed:{
            // total:function(){
            //     return this.subtotal + this.shipping + this.hst;
            // }
        },
        mounted(){
            this.reloadElement();
            },
            
        methods:{
            reloadElement(){
                // get items # from localstorage 
                for (let i = 0; i < this.storage.length; i++) {
                    this.items.push(this.storage.key(i));
                };
                // get item information 
                let data = this.items;
                this.$http.post('/api/getItems_carts/',{data:data}).then(response => {
                    this.carts = response.data.carts;
                    this.subtotal = 0;                
                    this.carts.forEach(element => {
                        this.subtotal += (element.pricel) * parseInt(this.storage.getItem(element.item));
                    });
                    console.log(this.subtotal);
                        
                }, response => {
                        // error 
                    console.log("error");
                });
            },
            
            removeFromCart(item){
                this.$confirm('Are you sure to delete the item from shopping cart.', 'Warning', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                    }).then(() => {
                        this.$message({
                            type: 'success',
                            message: 'Scuccessfully delete!',
                        });
                        this.items = [];
                        this.storage.removeItem(item);
                        // get items # from localstorage 
                        for (let i = 0; i < this.storage.length; i++) {
                            this.items.push(this.storage.key(i));
                        };
                        this.$http.post('/api/getItems_carts/',{data:this.items}).then(response => {
                            this.carts = response.data.carts;
                            // subtotal 
                            this.subtotal = 0;
                            this.carts.forEach(element => {
                                this.subtotal += (element.pricel) * parseInt(this.storage.getItem(element.item));
                            });
                        }, response => {
                                // error 
                            console.log("error");
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
                if (value>item.onhand) {
                    this.$alert('Out of stock', 'Warning', {
						confirmButtonText: 'OK',
					});
                }else{
                    this.storage.removeItem(item.item);
                    this.storage.setItem(item.item,value);
                    this.items = [];
                    this.reloadElement();        

                }
                
            }

            
            
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
        font-size: 28px;
        color: white;
        font-weight: bold;
        background: #009456;
        border-radius: 5px;
        padding: 5px 20px;
    }
    .fakeLink{
        cursor: pointer;
        
    }
    
</style>

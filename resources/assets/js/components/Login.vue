<template>
    <div class='container loginPage' @keyup.enter="loginTo()">
        <div class="col-xs-12 col-sm-6" id='loginDev' >
            <div class="text-center row" id='loginForm'>
                
                <div class='title'>Login</div>
                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="text" placeholder="Email Address" class="form-control" v-model='email'>
                </div>
                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="password" placeholder="Password" class="form-control" v-model='password'>
                </div>
                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <button class="btn btn-primary col-xs-12" id='loginBtn' @click="loginTo()">Login</button>
                </div>
                <div class="col-xs-8 col-xs-offset-2 form-group remeber">
                    <div>
                        <!-- <input type="checkbox"  value='RemeberPassword' placeholder="remeber">
                        <span class='forgetPassword'>Remember my GLA ID</span> -->
                    </div>
                    <div>
                        <span class='forgetPassword' @click='forget()'><i><u>Forgot Password?</u></i></span>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-xs-12 col-sm-6" id='registerDev'>
            <div id='registerForm' class='text-center'>
                <div class='title' >Register</div >
                <div class='form-group'>
                    <p>
                        Register a Golden Leaf Automotive account for a better shopping
                        experience. You will be able to place order, check order status,
                        shipping progress and fast and easy check out.
                    </p>
                </div>
                
                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <button class="btn btn-danger col-xs-12" id='loginBtn' @click="toRegister()">Register New Account</button>
                </div>
                
            </div>
        </div>
        <div class="panel panel-default col-xs-12">
            <div class="panel-heading">
                <h3 class="panel-title">Log In Help</h3>
            </div>
            <div class="panel-body">
                If you are having problems logging in, try the following: <br>
                1. Enable Cookies. <br>
                2. Enable Javascript. <br>
                3. Refresh the page. <br>
                If you are still experiencing problems, try using this link to reset your cookies and reload the page automatically.
                
            </div>
            
            
        </div>
        
    </div>
</template>


<script>
export default {
    data(){
        return {
            email:'',
            password:'',
            storage:window.localStorage,
        }
    },
    mounted(){
        // check if user is login
		if(this.storage.getItem('userInfo')){
				
            let userData = JSON.parse(this.storage.getItem('userInfo'));
            this.$router.push('home');
		}else{
			this.$router.push('Login');
        }
        
    },
    computed:{
        loginStatus(){
            return this.$store.state.loginStatus;
        },
        loginDirect(){
            return this.$store.state.loginDirect;
        }
    },
    methods:{
        loginTo(){
            this.$http.post('/api/loginCustomer', {email: this.email, password:this.password}).then(
                function(response){
                    var myStorage = localStorage;
                    
                    myStorage.setItem('user', JSON.stringify(response.data.user));

                    myStorage.setItem('userInfo', JSON.stringify(response.data.userInfo));

                    myStorage.setItem('billing', JSON.stringify(response.data.billing));
                    if (response.data.userInfo) {
                        if (response.data.userInfo.m_country=='US'){
                            this.$store.commit('usdPrice',true);
                        }else{
                            this.$store.commit('usdPrice',false);
                        }
                    }

                    if (this.storage.getItem('user')) {
                        this.user = JSON.parse(this.storage.getItem('user'));
                        let cust_id = this.user.id;

                        this.$http.get('/api/getShortlist/'+cust_id).then((response)=>{
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
                            }else{

                            }
                        }));
                    }else{
                    }

                    this.$store.commit('changeLoginStatus',true);
                    
                    this.$router.push(this.loginDirect);
                    
                }).catch(function(response){
                    // Your account or password was entered incorrectly.
                    if(response.status === 401) {
                        this.$message({
                            showClose: true,
                            message: 'Your email or password was entered incorrectly.',
                            type: 'error',
                            duration:8000
                        });
                    
                    }
                
                });
        

        },
        toRegister(){
            this.$router.push('/register');
        },

        forget(){
            this.$router.push('/forgetPassword');
        },
    }
}
</script>


<style scoped>
    .forgetPassword{
        cursor: pointer;
    }

    .title{
        font-size: 28px;
        font-weight: bold;
        line-height: 40px;
        padding-bottom:30px;
    }
    #loginDev, #registerDev{
        margin-bottom:50px;
        margin-top: 50px;
        display: flex;
        align-items: center;
    }
    

     
    p{
        padding:0 50px;
        min-height:85px;
        padding-bottom: 15px;
    }

    .remeber{
        display: flex;
        justify-content: space-between;
    }
    
    @media screen and (min-width:768px){
        #loginDev{
            border-right: 1px solid black;
        }

        #loginDev, #registerDev{
            min-height:400px;
        }

        #registerForm{
            min-height: 260px;
        }
    }

    @media screen and (max-width:768px){
        #loginDev{
            border-bottom: 1px solid black;
        }
    }
    
</style>


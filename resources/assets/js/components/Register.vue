<template>
    <div class='container '>
        <div class="col-xs-1"></div>
        <div class="text-center col-xs-10 " id='registerForm' >
                <div class="col-xs-8 col-xs-offset-2 form-group title-span" >
                    <span class='title'>NEW CUSTOMER</span>
                    <span class='haveAccount'>Have an account? <router-link tag='a' to='/login'>Sign in</router-link></span>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="text" placeholder="Name" class="form-control" v-model='username' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="email" placeholder="Email Address" class="form-control" v-model='email' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="password" placeholder="Password" class="form-control" v-model='password' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="password" placeholder="Confirm Password" class="form-control" v-model='confirm' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group remeber">
                    <div>
                        <input type="checkbox"  value='RemeberPassword' placeholder="remeber" v-model='receiveEmail'>
                        <span class='forgetPassword'>Click here to agree to allow Newegg Canada to send you 
                            exclusive email offers and discounts. You can unsubscribe at any time.</span>
                    </div>
                    
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <button class="btn btn-success col-xs-12" id='loginBtn' @click="register()">Register</button>
                </div>

                
            </div>
            <div class="col-xs-1"></div>
            <div class="col-xs-10 col-xs-offset-1" v-if="summary">
                <div class="col-xs-8 col-xs-offset-2">
                    Username : {{ username}}<br>
                    Email : {{ email}}<br>
                    Password: {{ password}}<br>
                    receiveEmail: {{ receiveEmail}}

                </div>
                
            </div>
        
    </div>
</template>


<script>
export default {
    data(){
        return {
            errors:[],
            username:null,
            email:null,
            password:null,
            confirm:null,
            receiveEmail:false,
            summary:false,
            storage:window.localStorage,
        }
    },
    methods:{
        register(){
            this.$http.post('/api/newCustomer',{
                'username':this.username,
                'email':this.email,
                'password':this.password,
                'receiveEmail':this.receiveEmail, 
                }).then(
                function(response){
                    this.storage.setItem('user',response.data.user);
                    this.storage.setItem('userInfo',response.data.userInfo);
                    this.$store.commit('changeLoginStatus',true);
                    this.$router.push('/');
                }),(function(response){
                    
                });
        }
    }
}
</script>


<style scoped>
    #registerForm{
        margin:50px auto;
    }
    .title-span{
        display: flex;
        justify-content: space-between;
        
    }
    .title{
        font-size: 28px;
        line-height: 40px;
    }
    .haveAccount{
        font-size: 18px;
        line-height: 40px;
    }

    
</style>


<template>
    <div class='container' @keyup.enter='register()'>
        <div class="text-center col-xs-12 " id='registerForm' >
                <div class="col-xs-8 col-xs-offset-2 form-group title-span" >
                    <span class='title'>NEW CUSTOMER<br>EXPRESS REGISTRATION</span>
                    <span class='haveAccount'>Already have an account? <router-link tag='a' to='/login'>Sign in</router-link></span>
                </div>

                <div class="col-xs-4 col-xs-offset-2 form-group">
                    <input type="text" placeholder="First Name" class="form-control" v-model='firstname' required>
                </div>

                <div class="col-xs-4  form-group">
                    <input type="text" placeholder="Last Name" class="form-control" v-model='lastname' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="email" placeholder="Email Address" class="form-control" v-model='email' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="password" id='password' placeholder="Password" class="form-control" v-model='password' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <input type="password" placeholder="Confirm Password" class="form-control" 
                     v-model='confirm' required>
                </div>

                <div class="col-xs-8 col-xs-offset-2 form-group remeber">
                    <div>
                        <input type="checkbox"  value='RemeberPassword' placeholder="remeber" v-model='receiveEmail'>
                        <span class='forgetPassword'>Click here to disagree to allow Golden Leaf Automotive to send you 
                            exclusive email offers and discounts. You can unsubscribe at any time.</span>
                    </div>
                    
                </div>
                <div class="col-xs-8 col-xs-offset-2 form-group">
                    <button class="btn btn-success col-xs-12" id='loginBtn' @click="register()">Register</button>
                </div>
            </div>
            
            <div class="col-xs-10 col-xs-offset-1" v-if="summary">
                <div class="col-xs-8 col-xs-offset-2">
                    First Name : {{ frstname }}<br>
                    Last Name : {{ lastname }}<br>
                    Email : {{ email}}<br>
                    Password: {{ password}}<br>
                    receiveEmail: {{ receiveEmail}}
                </div>
                
            </div>
        
    </div>
</template>


<script>
    export default{
        data(){
            return {
                errors:[],
                username:null,
                firstname:null,
                lastname:null,
                email:null,
                password:null,
                confirm:null,
                receiveEmail:true,
                summary:false,
                storage:window.localStorage,
            }
        },
        methods:{
            checkPwd(str) {
                if (str.length < 8) {
                    return("Password minimal length is 8.");
                } else if (str.length > 50) {
                    return("Password too long.");
                } else if (str.search(/\d/) == -1) {
                    return("Password must contain number and alphabet.");
                } else if (str.search(/[a-zA-Z]/) == -1) {
                    return("Password must contain number and alphabet.");
                } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
                    return("Password must contain number and alphabet.");
                }
                return("ok");
            },
            register(){

                if (this.password!=this.confirm) {
                    this.$message(
                        {
                            message:'Password Confirmation does not match Password',
                            type:'error', 
                        }
                    );
                    return false;
                }

                if (this.checkPwd(this.password)!="ok") {
                    this.$message(
                        {
                            message:this.checkPwd(this.password),
                            type:'error', 
                        }
                    );
                    return false;
                }

                
                this.$http.post('/api/newCustomer',{
                    'lastname':this.lastname,
                    'firstname':this.firstname,
                    'email':this.email,
                    'password':this.password,
                    'receiveEmail':this.receiveEmail, 
                    }).then(
                    function(response){
                        
                        if (response.data.status=="userExists") {
                            this.$message(
                                {
                                    message:'The Email has been used.',
                                    type:'error', 
                                }
                            );
                            return false;
                        }
                        console.log(response);
                        console.log(response.data.user);
                        this.storage.setItem('user',JSON.stringify(response.data.user));
                        this.storage.setItem('userInfo',JSON.stringify(response.data.userInfo));
                        this.$store.commit('changeLoginStatus',true);

                        this.$confirm('', 'Congratulation', {
                            confirmButtonText: 'Fill in Details',
                            cancelButtonText: 'Start Shopping',
                            type: 'success',
                            center: true
                            }).then(() => {
                                this.$router.push({name:'userHome'});
                            }).catch(() => {
                                console.log(123);
                                this.$router.push({path:'/'});
                                
                        });

                        // this.$confirm('', 'Congratulation', {
                        //     confirmButtonText: 'Start Shopping',
                        //     cancelButtonText: 'Fill in Details',
                        //     type: 'success',
                        //     center: true
                        //     }).then(() => {
                        //         this.$router.push({name:''});
                        //     }).catch(() => {
                        //         console.log(123);
                        //         this.$router.push({name:'userHome'});
                        // });

                        
                        
                    },function(response){
                        this.$message(
                                {
                                    message:'Please Check Your Input.',
                                    type:'error',
                                }
                            );
                    });
            },
        }
    }
</script>


<style scoped>
    #registerForm{
        margin:50px auto;
    }
    .title-span{
        display: flex;
        text-align: left;
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


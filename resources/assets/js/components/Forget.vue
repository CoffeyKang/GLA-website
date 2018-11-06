<template>
    <div class='container' @keyup.enter='register()'>
        <div class="text-center col-xs-12 " id='registerForm' >
                <div class="col-xs-8 col-xs-offset-2 form-group title-span" >
                    <span class='title'>LOG IN ASSISTANCE</span>
                    <span class='haveAccount'>Back to Log in. <router-link tag='a' to='/login'>Sign in</router-link></span>
                </div>
                <div class="col-xs-2"></div>
                <div class="col-xs-8 col-xs-offset-2">
                
                    <el-form :rules="rules" :model="details" ref="details" size="medium">

                        <div class="inRow" >
                            <div class="col-xs-12">
                                <el-form-item  prop='email' > 
                                    <el-input id='email' type="email" placeholder="Email Address"  v-model='details.email'></el-input>
                                </el-form-item>
                            </div>
                        </div>

                        <div class="inRow" >
                            <el-form-item prop='firstname' class='col-xs-6' style='padding-right:5px !important'>
                                <el-input v-model="details.firstname" placeholder="First Name" ></el-input>
                            </el-form-item>

                            <el-form-item  prop='lastname' class='col-xs-6' style='padding-left:5px !important'>
                                <el-input v-model="details.lastname" placeholder="Last Name"  ></el-input>
                            </el-form-item>
                        </div>

                        

                        <div class="inRow" >
                            <div class="col-xs-12">
                                <el-form-item  prop='password'>
                                    <el-input type="password" class='password' placeholder="New Password"  v-model='details.password'></el-input>
                                </el-form-item>
                            </div>
                        </div>

                        <div class="inRow" >
                            <div class="col-xs-12">
                                <el-form-item  prop='confirm'>
                                    <el-input type="password" class='password' placeholder="Confirm Password"  v-model='details.confirm'></el-input>
                                </el-form-item>
                            </div>
                        </div>

                        <div class="inRow">

                            <div class="col-xs-12">
                                <el-form-item>
                                    <el-button type="success"  style="width: 100%; font-size:24px; padding:5px;" @click="register()">Reset Password </el-button>
                                </el-form-item>
                            </div>
                            
                        </div>
                    </el-form>
                </div>
                
            </div>
            
           
        
    </div>
</template>



<script>
    
  

    export default{

        
        data(){
            
            return {
                errors:[],
                reload:false,
                username:null,
                firstname:null,
                lastname:null,
                email:null,
                password:null,
                confirm:null,
                receiveEmail:true,
                summary:false,
                myCaptcha:'',
                myCap:false,
                storage:window.localStorage,
                details:{
                    firstname:'',
                    lastname:'',
                    email:'',
                    password:'',
                    confirm:'',
                    checked:true,
                    
                },
                rules:{
                    firstname:[
                        { required: true, message: 'FIrst name is required.', trigger: 'blur', max:99 }
                    ],
                    lastname:[
                        { required: true, message: 'Last name is required.', trigger: 'blur', max:99 },
                    ],

                    email:[
                        { required: true,  message: 'Email is required.', trigger: 'blur', max:99 },
                        { type: 'email',  message: 'invaldate email.', trigger: 'blur', max:99 },
                    ],

                    password:[
                        { required: true, message: 'Password is required.', trigger: 'blur', max:99 },
                        { min: 8, message: 'Password minimal length is 8.', trigger: 'blur', max:99 },
                    ],

                    confirm:[
                        { required: true, message: 'Confirm password is required.', trigger: 'blur', max:99 },
                        { min: 8, message: 'Password minimal length is 8.', trigger: 'blur', max:99 },
                    ],
                }
            }
        },

        mounted(){
            
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
                this.$refs["details"].validate((valid)=>{
                    if(valid){

                        if (this.password!=this.confirm) {
                            this.$message(
                                {
                                    message:'Password Confirmation does not match Password',
                                    type:'error', 
                                }
                            );
                            return false;
                        }

                        if (this.checkPwd(this.details.password)!="ok") {
                            this.$message(
                                {
                                    message:this.checkPwd(this.details.password),
                                    type:'error', 
                                }
                            );
                            $('.password').css('border-color','red');
                            return false;
                        }

                        if (this.details.password!= this.details.confirm) {
                            this.$message(
                                {
                                    message:'confirm password not match',
                                    type:'error', 
                                }
                            );
                            $('.password').css('border-color','red');
                            return false;
                        }
                        /** check captcha */

                                this.$http.post('/api/resetPassword',{
                                    'lastname':this.details.lastname,
                                    'firstname':this.details.firstname,
                                    'email':this.details.email,
                                    'password':this.details.password,
                                    
                                    

                                    }).then((response)=>{
                                        
                                        if (response.data.status=="userNotExists") {
                                            this.$message(
                                                {
                                                    message:'Can not find this user.',
                                                    type:'error', 
                                                }
                                            );
                                            // $().ready(function(){
                                            // $('#email').css('background-color','#f56c6c !important');
                                                
                                            // });
                                            return false;
                                        }else{
                                            this.$message({
                                                message:"Password reset, please log in.",
                                                type:'success',
                                            });
                                            this.$router.push('/login');
                                        }

                                        
                                        
                                        
                                    });
                            }
                           
                       

                        


                        
                            
                        
                    
                  
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
    .inRow{
        display: flex;
        justify-content: space-between;
    }
    .col-xs-6, .col-xs-12 ,.col-xs-5 {
        padding:0;
    }

    .checkboxDiv{
        cursor: pointer;
    }
</style>


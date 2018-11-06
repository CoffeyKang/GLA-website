<template>
    <div class='container' @keyup.enter='register()'>
        <div class="text-center col-xs-12 " id='registerForm' >
                <div class="col-xs-8 col-xs-offset-2 form-group title-span" >
                    <span class='title'>NEW CUSTOMER<br>EXPRESS REGISTRATION</span>
                    <span class='haveAccount'>Already have an account? <router-link tag='a' to='/login'>Sign in</router-link></span>
                </div>
                <div class="col-xs-2"></div>
                <div class="col-xs-8 col-xs-offset-2">
                
                    <el-form :rules="rules" :model="details" ref="details" size="medium">
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
                                <el-form-item  prop='email' > 
                                    <el-input id='email' type="email" placeholder="Email Address"  v-model='details.email'></el-input>
                                </el-form-item>
                            </div>
                        </div>

                        <div class="inRow" >
                            <div class="col-xs-12">
                                <el-form-item  prop='password'>
                                    <el-input type="password" class='password' placeholder="Password"  v-model='details.password'></el-input>
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
                            <div class="col-xs-6">
                                <div>
                                    <!-- <el-input type="checkbox"  value='RemeberPassword' placeholder="remeber" v-model='receiveEmail'></el-input>
                                    -->
                                    <el-checkbox v-model="details.checked"></el-checkbox>
                                    <span class='checkboxDiv' @click='details.checked = !details.checked'>Click here to disagree to allow Golden Leaf Automotive to send you 
                                        exclusive email offers and discounts. You can unsubscribe at any time.</span>
                                </div>
                            </div>
                            <div class="col-xs-1"></div>
                            <div class="col-xs-5">
                                <div id="myCaptcha"></div>
                            </div>
                        </div>
                        <div class="inRow">
                            <div class="col-xs-12">
                                <br>
                            </div>
                        </div>
                        <div class="inRow">

                            <div class="col-xs-12">
                                <el-form-item>
                                    <el-button type="success"  style="width: 100%; font-size:24px; padding:5px;" @click="register()">Register </el-button>
                                </el-form-item>
                            </div>
                            
                        </div>
                    </el-form>
                </div>
                <!-- <div class="col-xs-4 col-xs-offset-2 form-group">
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
                </div> -->
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
            let recaptchaScript = document.createElement('script')
                recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit" async defer')
                document.head.appendChild(recaptchaScript)
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
                        this.$http.post('/api/checkCaptcha',{
                            'response':window.localStorage.getItem('captcha'),
                        },{emulateJSON: true}).then((response)=>{
                            
                            if (response.data.resp.success==true||this.myCap==true) {
                                 window.localStorage.removeItem('captcha');
                                this.myCap = true;

                                this.$http.post('/api/newCustomer',{
                                    'lastname':this.details.lastname,
                                    'firstname':this.details.firstname,
                                    'email':this.details.email,
                                    'password':this.details.password,
                                    'receiveEmail':this.details.receiveEmail,
                                    'myCaptcha':this.myCaptcha,
                                    "checked":this.details.checked, 
                                    'captcha': grecaptcha.getResponse()

                                    }).then((response)=>{
                                        
                                        if (response.data.status=="userExists") {
                                            this.$message(
                                                {
                                                    message:'The Email has been used.',
                                                    type:'error', 
                                                }
                                            );
                                            // $().ready(function(){
                                            // $('#email').css('background-color','#f56c6c !important');
                                                
                                            // });
                                            return false;
                                        }

                                        console.log(response);
                                        console.log(response.data.user);
                                        this.storage.setItem('user',JSON.stringify(response.data.user));
                                        this.storage.setItem('userInfo',JSON.stringify(response.data.userInfo));
                                        this.$store.commit('changeLoginStatus',true);
                                        this.$router.push({name:'userHome'});
                                        
                                        // this.$confirm('', 'Congratulation', {
                                        //     confirmButtonText: 'Fill in Details',
                                        //     cancelButtonText: 'Start Shopping',
                                        //     type: 'success',
                                        //     center: true
                                        //     }).then(() => {
                                        //         this.$router.push({name:'userHome'});
                                        //     }).catch(() => {
                                        //         console.log(123);
                                        //         this.$router.push({path:'/'});
                                                
                                        // });
                                    });
                            }else{
                                this.$message.error('Please check the Captcha box.');
                                
                                return false;
                            }
                           
                        });

                        


                        
                            
                        
                    
                    }else{
                        // this.$message({
                        //     showClose:true,
                        //     message:"Error Submit",
                        //     type:"error",
                        //     duration:5000,
                        // });
                        // return false;
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


<template>
    <div>
        <!-- personal information -->
        <div class="edit_title">
            Change Your Password
        </div>
        <el-form  label-position="left" label-width="160px"  size="medium" :rules="rules" :model="pass" ref='pass'>

            <div class='part'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        New Password
                    </div>
                    <div class="text">
                        <el-form-item label="Account">
                            <el-input v-model="account" placeholder="Account" :disabled='true'></el-input>
                        </el-form-item>

                        <el-form-item label="Old Password" prop='oldPass'>
                            <el-input type='password' v-model="pass.oldPass" placeholder="Old Password" ></el-input>
                        </el-form-item>

                        <el-form-item label="New Password" prop='newPass'>
                            <el-input type='password' v-model="pass.newPass" placeholder="New Password" ></el-input>
                        </el-form-item>

                        <el-form-item label="Confirm Password" prop='confirmPass'>
                            <el-input type='password' v-model="pass.confirmPass" placeholder="Confirm Password"  ></el-input>
                        </el-form-item>
                        
                        
                    </div>
                </el-card>
            </div>

            <div class="part text-right">
                <el-form-item>
                    <el-button type='default' @click="resetForm(pass)">Cancel</el-button>
                    <el-button type="success" @click="submitForm(pass)">Update</el-button>
                </el-form-item>
            </div>
        </el-form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            storage: window.localStorage,
            user:{},
            account:'',
            pass:{
                oldPass:'',
                newPass:'',
                confirmPass:'',
            },
            rules:{
                oldPass:[
                    { required: true, message: 'Password is required.', trigger: 'blur', max:99 },
                    // { min:8, message:'Minimal lenght is 8',trigger: 'blur'}
                ],
                newPass:[
                    { required: true, message: 'New Password is required.', trigger: 'blur', max:99 },
                    { min:8, message:'Minimal lenght is 8',trigger: 'blur'}
                ],
                confirmPass:[
                    { required: true, message: 'Password confirm is required.', trigger: 'blur',  max:99 },
                    { min:8, message:'Minimal lenght is 8',trigger: 'blur'}
                ],
            }
        }
        
    },

    mounted(){
        this.user = JSON.parse(this.storage.getItem('user'));
        this.account = this.user.account;
    },

    computed: {
        
    },

    methods:{
        submitForm(pass){
                this.$refs["pass"].validate((valid)=>{
                    if (valid){
                        
                        if (this.pass.newPass!=this.pass.confirmPass) {
                            this.$message(
                                {
                                    message:'Password Confirmation does not match Password',
                                    type:'error', 
                                }
                            );
                            return false;
                        }else{
                             
                        }

                        if (this.checkPwd(this.pass.newPass)!='ok') {
                            this.$message({
                                message:this.checkPwd(this.pass.newPass),
                                type:'error',
                            });
                            return false;
                        }else{

                        }
                        
                        // submit userDetails info        
                        var userId = this.user.id;
                        this.userID = userId;
                        this.$http.post('/api/changePass',{
                            data:this.pass,
                            userID:this.userID,
                            account:this.account,
                        }).then((response)=>{ 


                            return false;
                            if (response.data.status=="OK") {
                                this.storage.setItem('user',JSON.stringify(response.data.user));
                                this.user = JSON.parse(this.storage.getItem('user'));
                                this.$message({
                                    showClose:true,
                                    message:"Change Password Successfully",
                                    type:"success",
                                    duration:5000, 
                                });
                            }else{
                                this.$message({
                                    showClose:true,
                                    message:"Invalid input",
                                    type:"warning",
                                    duration:5000, 
                                });
                            }
                            
                        
                        }, response=>{
                            this.$message({
                                showClose:true,
                                message:"Invalid password",
                                type:"error",
                                duration:5000,
                            });
                                return false;
                            }
                        
                        );
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
            } ,


            resetForm(pass){
                this.$refs["pass"].resetFields();
            },
    },

}
</script>
    
<style>
    .edit_title{
        background-color: black;
        color: white;
        font-weight: bold;
        font-size: 22px;
        padding: 10px 0 10px 30px;
        border-radius: 10px;
    }
    .part{
        margin-top:20px;
    }
    .inRow{
        display: flex;
        justify-content: space-around;
    }
    

</style>    

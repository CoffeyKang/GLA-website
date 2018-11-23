<template>
    <div>

        <div class="edit_title" >
            Submit Inquiry
        </div>
        <div v-if="success" style='margin-top:30px;'>
            <el-alert
                title="Thank you for your email, GLA will contact you as soon as possible."
                type="success"
                show-icon>
            </el-alert>
        </div>
        <div class="email_form">
            <el-form ref="form" :model="email" label-width="80px" :rules="rules">
                <el-form-item label="Subject" prop='subject'>
                    <el-input v-model="email.subject" placeholder="Subject"></el-input>
                </el-form-item>

                <el-form-item label="Message" prop='messege'>
                    <el-input
                        type="textarea"
                        :rows="8"
                        placeholder="Leave messages"
                        v-model="email.messege">
                    </el-input>
                </el-form-item >
                <el-form-item class='text-right' >
                    <el-button type='success' @click="sendMessage()"> Send Messege </el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            storage : window.localStorage,
            userInfo:{},
            user:{},
            orderHistory:[],
            billing:{},
            success:false,
            email:{
                user : JSON.parse(window.localStorage.getItem('userInfo')).custno + ', '+ JSON.parse(window.localStorage.getItem('userInfo')).company,
            },
            rules:{
                subject:[
                    { required: true, message: 'Subject is required.', trigger: 'blur', max:99 }
                ],
                messege:[
                    { required: true, message: 'Message content required.', trigger: 'blur' },
                    { min: 20 , message: 'Message content minimal length is 20 characters.', trigger: 'blur',},

                ]
            }
        }
    },

    mounted(){
        
        
    },

    computed: {
        
    },
    methods:{
        sendMessage(){
            this.$refs["form"].validate((valid)=>{
                    if(valid){
                        this.$http.post('/api/inquiry',{
                            subject:this.email.subject,
                            user:this.email.user,
                            messege:this.email.messege,
                            type:"dealer"
                        }).then(response=>{
                            if (response.data.status) {
                                this.success = true;

                                this.email.subject = '';
                                this.email.messege = '';
                            }
                        })
                    }else{
                        
                    }
            })
        }
    }

}
</script>

<style>
    .edit_title{
        background-color: black;
        color: white;
        font-weight: bold;
        padding: 10px 0 10px 30px;
        border-radius: 10px;
    }
    .email_form{
        margin: 30px 0;
    }
    

</style>    

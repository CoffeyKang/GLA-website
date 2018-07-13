<template>
    <div>
        <!-- personal information -->
        <div class="edit_title">
            Edit Your Profile
        </div>
        <el-form  label-position="left" label-width="80px" :rules="rules" :model="details" ref="details" size="mini">

            <div class='part'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Personal Information
                    </div>
                    <div class="text">
                        <div class="inRow">
                            <el-form-item label="Surname" prop='surname'>
                                <el-input v-model="details.surname" placeholder="Surname" ></el-input>
                            </el-form-item>

                            <el-form-item label="Forename" prop='forename'>
                                <el-input v-model="details.forename" placeholder="Furname"  ></el-input>
                            </el-form-item>
                        </div>
                        <div class="inRow">
                            <el-form-item label="Birthday" prop='brithday' >
                                <el-input type='date' v-model="details.brithday"   ></el-input>
                            </el-form-item>

                            <el-form-item label="Gender" prop='gender' >
                                <el-select v-model="details.gender" placeholder="Gender">
                                    <el-option
                                    v-for="gender in ['Male','Female']"
                                    :key="gender"
                                    :label="gender"
                                    :value="gender">
                                    </el-option>
                                </el-select>
                            </el-form-item>

                            
                        </div>
                    </div>
                </el-card>

                
                
            </div>

            <!-- shipping information -->
            <div class='part'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Shipping Information
                    </div>
                    <div class="text">
                        <div class="inRow">
                            <el-form-item label="City" prop='city'>
                                <el-input v-model="details.city" placeholder="City"  ></el-input>
                            </el-form-item>

                            <el-form-item label="State" prop='state'>
                                <el-select v-model="details.state" placeholder="State">
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
                            <el-form-item label="ZIPCODE"  prop='zipcode'>
                                <el-input v-model="details.zipcode" placeholder="ZIPCODE" ></el-input>
                            </el-form-item>

                            <el-form-item label="Country" prop='country'>
                                <el-input v-model="details.country" placeholder="Country"  ></el-input>
                            </el-form-item>
                        </div>

                        <div class="inRow">
                            <el-form-item label="Tel" prop='tel'>
                                <el-input type='number' v-model="details.tel" placeholder="Tel"></el-input>
                            </el-form-item>
                        
                            <el-form-item label="Mobile" prop='mobile'>
                                <el-input type='number' v-model="details.mobile" placeholder="Mobile"  ></el-input>
                            </el-form-item>
                        </div>
                        <el-form-item label="Address" prop='address'>
                            <el-input v-model="details.address" placeholder="Address"  ></el-input>
                        </el-form-item>
                    </div>
                </el-card>
                
            </div>
            
            <!-- other information -->
            <div class='part'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Other Information
                    </div>
                    <div class="text">
                        <div class="inRow">
                            <!-- <el-form-item label="Edu"  prop='education'>
                                <el-input v-model="details.edu" placeholder="Education" ></el-input>
                            </el-form-item> -->

                            <el-form-item label="Edu" prop='education'>
                                <el-select v-model="details.edu" placeholder="Edu">
                                    <el-option
                                    v-for="item in edu"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        
                            <el-form-item label="Job"  prop='job'>
                                <el-input v-model="details.job" placeholder="Job"  ></el-input>
                            </el-form-item>

                        </div>

                        <div class="inRow">

                        
                            <el-form-item label="Title" prop='tit'>
                                <el-input v-model="details.tit" placeholder="Title"  ></el-input>
                            </el-form-item>
                        
                            <el-form-item label="Car" prop='car'>
                                <el-input v-model="details.car" placeholder="Car" ></el-input>
                            </el-form-item>

                        </div>
                    </div>
                </el-card>

            </div>
            <div class="part text-right">
                <el-form-item>
                        <el-button type='default' @click="resetForm(details)">Cancel</el-button>
                        <el-button type="success" @click="submitForm(details)">Update</el-button>
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
            userInfo:{},
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
            details:{
                surname:'',
                forename:'',
                gender:'',
                brithday:'',
                address:'',
                city:'',
                state:'',
                zipcode:'',
                country:'',
                tel:'',
                mobile:'',
                edu:'',
                job:'',
                tit:'',
                car:'',
            },
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
                mobile:[
                    {message: 'Invalid telephone number.', trigger: 'blur',  max: 15,}
                ],
            },

            edu:[
                {value:1,label:'High School or Less'},
                {value:2,label:'College / Trade School'},
                {value:3,label:'University'},
                {value:4,label:'Graduate School'},
            ],
        }
        
    },

    mounted(){
        this.user = JSON.parse(this.storage.getItem('user'));
        this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
        this.details.surname = this.userInfo.m_surname;
        this.details.forename = this.userInfo.m_forename;
        this.details.gender = (this.userInfo.m_gender==1?"Male":"Female");
        this.details.brithday = this.userInfo.m_birth;
        this.details.address = this.userInfo.m_address;
        this.details.city = this.userInfo.m_city;
        this.details.state = this.userInfo.m_state;
        this.details.zipcode = this.userInfo.m_zipcode;
        this.details.country = this.userInfo.m_country;
        this.details.tel = this.userInfo.m_tel;
        this.details.mobile = this.userInfo.m_mobile;
        this.details.edu = this.userInfo.m_edu;
        this.details.job = this.userInfo.m_job;
        this.details.tit = this.userInfo.m_title;
        this.details.car = this.userInfo.m_car;
    },

    computed: {
        
    },

    methods:{
            submitForm(details){
                this.$refs["details"].validate((valid)=>{
                    if (valid){
                        // submit userDetails info        
                        var userId = this.user.id;
                        this.userID = userId;
                        this.$http.post('/api/updateUserInfo',{
                            data:this.details,
                            userID:this.userID,
                        }).then((response)=>{   
                            var info = response.data.userinfo;
                            this.storage.setItem('userInfo',JSON.stringify(info));
                            this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
                            this.$message({
                            showClose:true,
                            message:"Edit Successfully",
                            type:"success",
                            duration:5000,
                        });
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
            } ,
            resetForm(details){
                this.details.surname = this.userInfo.m_surname;
                this.details.forename = this.userInfo.m_forename;
                this.details.gender = (this.userInfo.m_gender==1?"Male":"Female");
                this.details.brithday = this.userInfo.m_birth;
                this.details.address = this.userInfo.m_address;
                this.details.city = this.userInfo.m_city;
                this.details.state = this.userInfo.m_state;
                this.details.zipcode = this.userInfo.m_zipcode;
                this.details.country = this.userInfo.m_country;
                this.details.tel = this.userInfo.m_tel;
                this.details.mobile = this.userInfo.m_mobile;
                this.details.edu = this.userInfo.m_edu;
                this.details.job = this.userInfo.m_job;
                this.details.tit = this.userInfo.m_title;
                this.details.car = this.userInfo.m_car;
            },
    },

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
    .part{
        margin-top:20px;
    }
    .inRow{
        display: flex;
        justify-content: space-around;
    }
    

</style>    

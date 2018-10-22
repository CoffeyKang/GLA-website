<template>
    <div>
        <!-- personal information -->
        <div class="edit_title">
            Edit Your Profile
        </div>
        <el-form  label-position="left" label-width="120px" :rules="rules" :model="details" ref="details" size="large">
            <div class='part'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Personal Information
                    </div>
                    <div class="text">
                        <div class="inRow">
                            <div class="col-xs-6">
                                <el-form-item label="Last Name" prop='surname'>
                                    <el-input v-model="details.surname" placeholder="Last Name" ></el-input>
                                </el-form-item>
                            </div>
                            <div class="col-xs-6">
                                <el-form-item label="First Names" prop='forename'>
                                    <el-input v-model="details.forename" placeholder="First Names"></el-input>
                                </el-form-item>
                            </div>
                        </div>
                        <div class="inRow">
                            <div class="col-xs-6">
                                <el-form-item label="Date of Birth" prop='brithday' >
                                    <el-input type='date' v-model="details.brithday"   ></el-input>
                                </el-form-item>
                            </div>
                            <div class="col-xs-6">
                                <el-form-item label="Gender" prop='gender' >
                                <el-select v-model="details.gender" placeholder="Gender">
                                    <el-option
                                    v-for="gender in ['Male','Female','I do not want to tell']"
                                    :key="gender"
                                    :label="gender"
                                    :value="gender">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            </div>
                            

                            
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
                            <div class="col-xs-12">
                                <el-form-item label="Address" prop='address'>
                                    <el-input v-model="details.address" placeholder="Address"  ></el-input>
                                </el-form-item>
                            </div>
                            
                        </div>

                        <div class="inRow">

                            <div class="col-xs-6">
                                <el-form-item label="City" prop='city'>
                                    <el-input v-model="details.city" placeholder="City"  ></el-input>
                                </el-form-item>
                            </div>
                            
                            <div class="col-xs-6">
                                <el-form-item label="Postal Code"  prop='zipcode'>
                                    <el-input v-model="details.zipcode" placeholder="Postal Code" ></el-input>
                                </el-form-item>
                            </div>
                            
                            
                            
                        </div>


                        <div class="inRow">
                            <div class="col-xs-6">
                                

                                <el-form-item label="Country" prop='country'>
                                    <el-select v-model="details.country" placeholder="Country" @change='details.state=""'>
                                        <el-option
                                        v-for="item in country"
                                        :key="item.name"
                                        :label="item.name"
                                        :value="item.Code">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </div>
                            <div class="col-xs-6">
                                <el-form-item label="Province" prop='state' v-if="details.country=='CA'">
                                    <el-select v-model="details.state" placeholder="Province">
                                        <el-option
                                        v-for="item in privince"
                                        :key="item.name"
                                        :label="item.name"
                                        :value="item.Code" >
                                        </el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item label="Province" prop='state' v-if="details.country=='US'">
                                    <el-select v-model="details.state" placeholder="Province">
                                        <el-option
                                        v-for="item in US_states"
                                        :key="item.name"
                                        :label="item.name"
                                        :value="item.abbreviation" >
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </div>
                            

                            
                        </div>

                        

                        <div class="inRow">
                            <div class="col-xs-6">
                                <el-form-item label="Tel" prop='tel'>
                                    <el-input type='number' v-model="details.tel" placeholder="Tel"></el-input>
                                </el-form-item>
                            </div>
                            
                            <div class="col-xs-6">
                                <el-form-item label="Mobile" prop='mobile'>
                                    <el-input type='number' v-model="details.mobile" placeholder="Mobile"  ></el-input>
                                </el-form-item>
                            </div>
                            
                        </div>
                        
                    </div>
                </el-card>
                
            </div>

            <div class='part'>
                <el-card class="box-card">
                    <div class="clearfix" slot="header">
                        Billing Information
                    </div>
                    <div class="text">
                        <div class="inRow">
                            <div class="col-xs-6">
                                <el-form-item label="Last Name" prop='surname'>
                                    <el-input v-model="details.b_lastname" placeholder="Last Name" ></el-input>
                                </el-form-item>
                            </div>
                            <div class="col-xs-6">
                                <el-form-item label="First Names" prop='forename'>
                                    <el-input v-model="details.b_firstname" placeholder="First Names"></el-input>
                                </el-form-item>
                            </div>
                        </div>
                        <div class="inRow">
                            <div class="col-xs-12">
                                <el-form-item label="address1" prop='address'>
                                    <el-input v-model="details.b_address1" placeholder="address1" ></el-input>
                                </el-form-item>
                            </div>
                            
                        </div>

                        <div class="inRow">
                            <div class="col-xs-12">
                                <el-form-item label="address2" prop='address'>
                                    <el-input v-model="details.b_address2" placeholder="address2" ></el-input>
                                </el-form-item>
                            </div>
                            
                        </div>

                        <div class="inRow">

                            <div class="col-xs-6">
                                <el-form-item label="City" prop='city'>
                                    <el-input v-model="details.b_city" placeholder="City"  ></el-input>
                                </el-form-item>
                            </div>
                            
                            <div class="col-xs-6">
                                <el-form-item label="Postal Code"  prop='b_zipcode'>
                                    <el-input v-model="details.b_zipcode" placeholder="Postal Code" ></el-input>
                                </el-form-item>
                            </div>
                            
                        </div>


                        <div class="inRow">
                            <div class="col-xs-6">
                                <el-form-item label="Country" prop='country'>
                                    <el-select v-model="details.b_country" placeholder="Country" @change='details.b_state=""'>
                                        <el-option
                                        v-for="item in country"
                                        :key="item.name"
                                        :label="item.name"
                                        :value="item.Code">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </div>
                            <div class="col-xs-6">
                                <el-form-item label="Province" prop='state' v-if="details.b_country=='CA'">
                                    <!-- <select v-model="billing.province" class='form-control'>
                                        <option v-for="item in privince" :key="item.name" :value="item.Code">{{ item. name}}</option>
                                    </select> -->
                                    <el-select v-model="details.b_state" placeholder="Province">
                                        <el-option
                                        v-for="item in privince"
                                        :key="item.name"
                                        :label="item.name"
                                        :value="item.Code" >
                                        </el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item label="State" prop='state' v-if="details.b_country=='US'">
                                    <el-select v-model="details.b_state" placeholder="Province">
                                        <!-- <select v-model="billing.province" class='form-control'>
                                            <option v-for="item in US_states" :key="item.name" :value="item.abbreviation">{{ item. name}}</option>
                                        </select> -->
                                        <el-option
                                            v-for="item in US_states"
                                            :key="item.name"
                                            :label="item.name"
                                            :value="item.abbreviation" >
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </div>
                            

                            
                        </div>

                        

                        <div class="inRow">
                            <div class="col-xs-12">
                                <el-form-item label="Tel" prop='tel'>
                                    <el-input type='number' v-model="details.b_tel" placeholder="Tel"></el-input>
                                </el-form-item>
                            </div>
                        </div>
                        
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
                            <div class="col-xs-12">
                                <div class="col-xs-5">
                                <el-form-item label="Car" prop='car'>
                                    <el-input v-model="details.car" placeholder="Make" ></el-input>
                                </el-form-item>
                                </div>
                                <div class="col-xs-3">
                                    <el-form-item label-width='0px' >
                                        <select v-model="details.year" class='form-control'>
                                            <option v-for="item in myRange(1949)" :key="item">{{ item }}</option>
                                        </select>
                                    </el-form-item>
                                </div>
                                <div class="col-xs-4">
                                    <el-form-item label-width='0px' >
                                        <el-input v-model="details.model" placeholder="Model"  ></el-input>
                                    </el-form-item>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </el-card>

            </div>
            <div class="part text-right">
                <el-form-item>
                    <el-button type='default' class='myB' @click="resetForm(details)">Reset</el-button>
                    <el-button type="success" class='myB' @click="submitForm(details)">Update</el-button>
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
            privince:this.$store.state.privince,
            country:this.$store.state.country,
            US_states:this.$store.state.US_states,
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
                b_firstname:'',
                b_lastname:'',
                b_address1:'',
                b_address2:'',
                b_city:'',
                b_province:'',
                b_country:'',
                b_phone:'',
                b_zipcode:'',
               
            },
            billing:{},
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
                    { required: true, message: 'Postal Code is required.', trigger: 'blur' },
                    { min:5, max:7, message: 'Please input valid postalcode.', trigger: 'blur'},
                ],

                b_zipcode:[
                    { required: true, message: 'Postal Code is required.', trigger: 'blur' },
                    { min:5, max:7, message: 'Please input valid postalcode.', trigger: 'blur'},
                ],
                
                address:[
                    { required: true, message: 'Address is required.', trigger: 'blur', max:99 },
                ],
                country:[
                    { required: true, message: 'Country is required.', trigger: 'blur', max:99 },
                ],
                tel:[
                    {required: true, message: 'Invalid telephone number.', trigger: 'blur',  max:10, min:10}
                ],
                mobile:[
                    {message: 'Invalid telephone number.', trigger: 'blur',  max:10, min:10}
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
        this.billing = JSON.parse(this.storage.getItem('billing'));

        this.details.surname = this.userInfo.m_surname;
        this.details.forename = this.userInfo.m_forename;
        this.details.gender = this.getGender(this.userInfo.m_gender);
        this.details.brithday = this.userInfo.m_birth;
        this.details.address = this.userInfo.m_address;
        this.details.city = this.userInfo.m_city;
        this.details.state = this.userInfo.m_state;
        this.details.zipcode = this.userInfo.m_zipcode;
        this.details.country =(this.userInfo.m_country=="US"?"US":"CA");
        this.details.tel = this.userInfo.m_tel;
        this.details.mobile = this.userInfo.m_mobile;
        
        this.details.model = this.userInfo.m_make;
        this.details.year = (this.userInfo.m_year<1950?1950:this.userInfo.m_year);
        this.details.car = this.userInfo.m_car;


        /** billing address */
        this.details.b_lastname = this.billing.lastname;
        this.details.b_firstname = this.billing.firstname;
        this.details.b_address1 = this.billing.address1;
        this.details.b_address2 = this.billing.address2;
        this.details.b_city = this.billing.city;
        this.details.b_state = this.billing.province;
        this.details.b_zipcode = this.billing.postalcode;
        this.details.b_country =(this.billing.country=="US"?"US":"CA");
        this.details.b_tel = this.billing.phone;

        
    },

    computed: {
        
    },

    methods:{
        changeYear(a){
            console.log(a);
            this.details.year = a;
            
        },
        
        submitForm(details){
            this.$refs["details"].validate((valid)=>{
                if (valid){
                    if (this.details.country=='US') {
                        let isValidZip = /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(this.details.zipcode);

                        if (!isValidZip) {
                            this.$message({
                                showClose:true,
                                message:"Please inter valid USA Zipcode",
                                type:"error",
                                duration:5000,
                            });
                            return false;
                        }else{
                        

                        }
                    }else{
                        let str = this.details.zipcode.replace(' ','');

                        if ($.isNumeric(str[1]+str[3]+str[5])&& this.isAlphaOrParen(str[0])&& this.isAlphaOrParen(str[2])&& this.isAlphaOrParen(str[0])) {
                        }else{
                            this.$message({
                                showClose:true,
                                message:"Please inter valid Canada postalcode",
                                type:"error",
                                duration:5000,
                            });
                            return false;
                        }
                    }

                    if (this.details.b_country=='US') {
                        let isValidZip = /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(this.details.b_zipcode);

                        if (!isValidZip) {
                            this.$message({
                                showClose:true,
                                message:"Please inter valid USA Zipcode",
                                type:"error",
                                duration:5000,
                            });
                            return false;
                        }else{
                        

                        }
                    }else{
                        let str = this.details.b_zipcode.replace(' ','');

                        if ($.isNumeric(str[1]+str[3]+str[5])&& this.isAlphaOrParen(str[0])&& this.isAlphaOrParen(str[2])&& this.isAlphaOrParen(str[0])) {
                        }else{
                            this.$message({
                                showClose:true,
                                message:"Please inter valid Canada postalcode",
                                type:"error",
                                duration:5000,
                            });
                            return false;
                        }
                    }

                    
                    // submit userDetails info        
                    var userId = this.user.id;
                    this.userID = userId;
                    this.$http.post('/api/updateUserInfo',{
                        data:this.details,
                        userID:this.userID,
                    }).then((response)=>{   
                        var info = response.data.userinfo;
                        var b = response.data.billing;
                        this.storage.setItem('userInfo',JSON.stringify(info));
                        this.storage.setItem('billing', JSON.stringify(response.data.billing));
                        this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
                        this.billing = JSON.parse(this.storage.getItem('billing'));
                        this.$message({
                        showClose:true,
                        message:"Edit Successfully",
                        type:"success",
                        duration:5000,
                    });
                    window.scrollTo(0,0);
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
        } ,
        resetForm(details){
            this.details.surname = this.userInfo.m_surname;
            this.details.forename = this.userInfo.m_forename;
            this.details.gender = this.getGender(this.userInfo.m_gender);
            this.details.brithday = this.userInfo.m_birth;
            this.details.address = this.userInfo.m_address;
            this.details.city = this.userInfo.m_city;
            this.details.state = this.userInfo.m_state;
            this.details.zipcode = this.userInfo.m_zipcode;
            this.details.country = (this.userInfo.m_country=="US"?"US":"CA");
            this.details.tel = this.userInfo.m_tel;
            this.details.mobile = this.userInfo.m_mobile;
            this.details.model = this.userInfo.m_make;
            this.details.year = (this.userInfo.m_year<1950?1950:this.userInfo.m_year);
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
        font-size: 22px;
        padding: 10px 0 10px 30px;
        border-radius: 10px;
    }
    .clearfix{
        font-size: 20px;
    }
    .part{
        margin-top:20px;
    }
    .inRow{
        display: flex;
        justify-content: space-around;
    }
    .myB{
        font-size: 20px;
    }
    
    select{
        height: 40px !important;
        border: 1px solid #dcdfe6 !important;
    }




</style>    

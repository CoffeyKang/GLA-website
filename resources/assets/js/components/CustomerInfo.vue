<template>
	<div class='adminPage'>

		<div v-if="hasInfo" class='container' >

            <div class="userNav col-xs-4">

            <div class='myAvatar'>
                <span> {{userInfo.m_forename + ' ' + userInfo.m_surname}}</span>
                <span> {{ userInfo.m_title }} </span>
            </div>
            <div class="list-group container-fuild">
                <router-link :to="{name:'setPromotion'}" tag='a' class='list-group-item'>Set promotion discount</router-link>
                <router-link :to="{name:'editUser'}" tag='a' class='list-group-item'>Set promotion discount</router-link>
                <a href="#" class="list-group-item">Customer and dealer report</a>
                <a href="#" class="list-group-item">Add new customer and dealer</a>
                <a href="#" class="list-group-item">Edit dealer and customer</a>
                <a href="#" class="list-group-item">Show deal order history</a>
                <a href="#" class="list-group-item">Show customer history</a>
                <a href="#" class="list-group-item">Pending quote</a>
                <a href="#" class="list-group-item">Awaits report</a>
            </div>
            </div>
        
            <div class="userContent col-xs-8">
                <router-view></router-view>  
            </div>
        </div>

        <!-- if do not have details, please enter details first -->
        <div v-if="!hasInfo" class='user_details container text-center' >

            <div style='margin:50px 0;'>

                <div class="alert alert-success text-left">
                    Register a MuscleCarPartsOutlet account for a better shopping experience. You will be able to place order, check order status, 
                    shipping progress and fast and easy check out. If you don't have an account, please create a new one.
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <el-form  label-position="left" label-width="80px" :rules="rules" :model="details" ref="details" size="medium">
                    
                    <el-form-item label="Surname" prop='surname'>
                        <el-input v-model="details.surname" placeholder="Surname" ></el-input>
                    </el-form-item>

                    <el-form-item label="Forename" prop='forename'>
                        <el-input v-model="details.forename" placeholder="Furname"  ></el-input>
                    </el-form-item>

                    <div class="inRow">
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

                        <el-form-item label="Birthday" prop='brithday' >
                            <el-input type='date' v-model="details.brithday"   ></el-input>
                        </el-form-item>
                    </div>
                    
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

                    <el-form-item label="Address" prop='address'>
                        <el-input v-model="details.address" placeholder="Address"  ></el-input>
                    </el-form-item>

                    <el-form-item label="Tel" prop='tel'>
                        <el-input type='number' v-model="details.tel" placeholder="Tel"></el-input>
                    </el-form-item>
                
                    <el-form-item label="Mobile" prop='mobile'>
                        <el-input type='number' v-model="details.mobile" placeholder="Mobile"  ></el-input>
                    </el-form-item>

                    <div class="inRow">
                        <el-form-item label="Edu"  prop='education'>
                            <el-input v-model="details.edu" placeholder="Education" ></el-input>
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
                    <el-form-item>
                        <el-button type='default' @click="resetForm(details)">Cancel</el-button>
                        <el-button type="success" @click="submitForm(details)">Register</el-button>
                    </el-form-item>
                </el-form>
                </div>
                <div class="col-sm-2"></div>
            </div>

        </div>
		
	</div>
</template>

<script>
	export default {
		data(){
			return {
                storage:window.localStorage,
                hasInfo:false,
                user:{},
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
                userInfo:{},
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
                    
                }
			}
		},
		mounted(){
            // this.userInfo = JSON.parse(this.storage.getItem('userInfo'));

            
            this.user = JSON.parse(this.storage.getItem('user'));
            this.userInfo = JSON.parse(this.storage.getItem("userInfo"));
            console.log(this.userInfo);
            if (this.userInfo) {
                
                this.hasInfo=true;
            
            }else{
                
                this.hasInfo=false;
            }

            console.log(this.hasInfo);
            
		},
		methods:{
            submitForm(details){
                console.log('submit form');
                this.$refs["details"].validate((valid)=>{
                    if (valid){
                        // submit userDetails info        
                        var userId = this.user.id;
                        this.userID = userId;
                        this.$http.post('/api/userDetails',{
                            data:this.details,
                            userID:this.userID,
                        }).then((response)=>{   
                            console.log(response.data);


                            var info = response.data.userinfo;

                            this.storage.setItem('userInfo',JSON.stringify(info));

                            this.hasInfo = true;

                            this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
                        
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
                this.$refs["details"].resetFields();
            },       
        },
        
	}
</script>

<style scoped>
	.adminPage, .userNav, .userContent{
        min-height: 1500px;

    }
    .adminPage{
        display: flex;
    }
    .userNav{
        width: 30%;
    }
    .userContent{
        width: 70%;
    }
    .userNav{
        background-color: gray;
    }
    .myAvatar{
        display: flex;
        flex-direction: column;
        font-size: 14px;
        height: 100px;
        justify-content: center;
        align-items: center;

    }
    .list-group,.list-group-item{
        color: black;
        background-color: gray;
        border-color: gray;
    }
    .inRow{
        display: flex;
        justify-content: space-between;
        
    }
    

    
	
</style>
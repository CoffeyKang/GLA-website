<template>
	<div class='container adminPage'>

        
		<div v-if="userInfo">
            <div class="userNav" >
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
            <div class="userContent">
                <router-view></router-view>  
            </div>
        </div>

        <!-- if do not have details, please enter details first -->
        <div if='!userInfo' class='user_details container text-center' >

            <div style='margin:50px 0;'>

                <div class="alert alert-success text-left">
                    Register a MuscleCarPartsOutlet account for a better shopping experience. You will be able to place order, check order status, 
                    shipping progress and fast and easy check out. If you don't have an account, please create a new one.
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <el-form  label-position="left" label-width="80px" 
                            :rules="rules" :model="details" 
                            ref="details" size="medium">
                    
                    <el-form-item label="Surname" prop='surname'>
                        <el-input v-model="surname" placeholder="Surname" ></el-input>
                    </el-form-item>

                    <el-form-item label="Forename" prop='forename'>
                        <el-input v-model="forename" placeholder="Furname"  ></el-input>
                    </el-form-item>

                    <div class="inRow">
                        <el-form-item label="Gender" prop='gender' >
                            <el-select v-model="gender" placeholder="Gender">
                                <el-option
                                v-for="gender in ['Male','Female']"
                                :key="gender"
                                :label="gender"
                                :value="gender">
                                </el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Birthday" prop='brithday' >
                            <el-input type='date' v-model="brithday"   ></el-input>
                        </el-form-item>
                    </div>
                    
                    <div class="inRow">

                        <el-form-item label="City" prop='city'>
                            <el-input v-model="city" placeholder="City"  ></el-input>
                        </el-form-item>

                        <el-form-item label="State" prop='state'>
                            <el-input v-model="state" placeholder="State"  ></el-input>
                        </el-form-item>
                        
                    </div>


                    <div class="inRow">

                        <el-form-item label="ZIPCODE"  prop='zipcode'>
                            <el-input v-model="zipcode" placeholder="ZIPCODE" ></el-input>
                        </el-form-item>

                        <el-form-item label="Country" prop='country'>
                            <el-input v-model="country" placeholder="Country"  ></el-input>
                        </el-form-item>
                    </div>

                    <el-form-item label="Address" prop='address'>
                        <el-input v-model="address" placeholder="Address"  ></el-input>
                    </el-form-item>

                    <el-form-item label="Tel" prop='tel'>
                        <el-input type='number' v-model="tel" placeholder="Tel"></el-input>
                    </el-form-item>
                
                    <el-form-item label="Mobile" prop='mobile'>
                        <el-input type='number' v-model="mobile" placeholder="Mobile"  ></el-input>
                    </el-form-item>

                    <div class="inRow">
                        <el-form-item label="Edu"  >
                            <el-input v-model="edu" placeholder="Education" ></el-input>
                        </el-form-item>
                    
                        <el-form-item label="Job"  prop='job'>
                            <el-input v-model="job" placeholder="Job"  ></el-input>
                        </el-form-item>

                        </div>

                    <div class="inRow">

                    
                        <el-form-item label="Title" prop='tit'>
                            <el-input v-model="tit" placeholder="Title"  ></el-input>
                        </el-form-item>
                    
                        <el-form-item label="Car" prop='car'>
                            <el-input v-model="car" placeholder="Car" ></el-input>
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
                user:JSON.parse(localStorage.getItem('user')),
                userInfo:JSON.parse(localStorage.getItem('userInfo')),
                storage:window.localStorage,
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
                details:{},
                rules:{
                    surname:[
                        { required: true, message: 'Surname is required.', trigger: 'blur', max:99 },
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
            console.log(this.userInfo);
            console.log(localStorage);
		},
		methods:{
            submitForm(details){
                this.$refs["details"].validate((valid)=>{
                    if (valid) {
                        // submit userDetails info
                        var userId = JSON.parse(this.storage.getItem("user")).id;
                        
                        this.userID = userId;

                        this.$http.post('/api/userDetails',{data:this.details}).then((response)=>{
                            console.log(response);
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
		}
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
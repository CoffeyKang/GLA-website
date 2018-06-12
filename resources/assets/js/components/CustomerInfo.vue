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
                <el-form  label-position="left" label-width="80px" :rules='rules'  :model="details">
                    
                    <el-form-item label="Surname">
                        <el-input v-model="surname" placeholder="Surname" prop='name'></el-input>
                    </el-form-item>

                    <el-form-item label="Forename">
                        <el-input v-model="forename" placeholder="Furname"  prop='name'></el-input>
                    </el-form-item>

                    <el-form-item label="Gender">
                        <el-input v-model="gender" placeholder="Gender"  prop='gender'></el-input>
                    </el-form-item>

                    <el-form-item label="Brithday">
                        <el-input v-model="forename" placeholder="Brithday"  prop='brithday'></el-input>
                    </el-form-item>
                    
                    <el-form-item label="City">
                        <el-input v-model="city" placeholder="City"  prop='city'></el-input>
                    </el-form-item>

                    <el-form-item label="State">
                        <el-input v-model="state" placeholder="State"  prop='state'></el-input>
                    </el-form-item>
                
                    <el-form-item label="ZIPCODE">
                        <el-input v-model="zpicode" placeholder="ZIPCODE"  prop='zipcode'></el-input>
                    </el-form-item>

                    <el-form-item label="Country">
                        <el-input v-model="country" placeholder="Country"  prop='country'></el-input>
                    </el-form-item>
                
                    <el-form-item label="Address">
                        <el-input v-model="address" placeholder="Address"  prop='address'></el-input>
                    </el-form-item>

                    <el-form-item label="Tel">
                        <el-input v-model="tel" placeholder="Tel"  prop='tel'></el-input>
                    </el-form-item>
                
                    <el-form-item label="Mobile">
                        <el-input v-model="mobile" placeholder="Mobile"  prop='mobile'></el-input>
                    </el-form-item>

                    <el-form-item label="Edu">
                        <el-input v-model="edu" placeholder="Education"  prop='edu'></el-input>
                    </el-form-item>
                
                    <el-form-item label="Job">
                        <el-input v-model="job" placeholder="Job"  prop='job'></el-input>
                    </el-form-item>

                    <el-form-item label="Title">
                        <el-input v-model="tit" placeholder="Title"  prop='title'></el-input>
                    </el-form-item>
                
                    <el-form-item label="Car">
                        <el-input v-model="car" placeholder="Car"  prop='car'></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button type='default'>Cancel</el-button>
                        <el-button type="success">Register</el-button>
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
                    title:'',
                    car:'',
                },

                rules:{
                    keyInfo: [
                        { required: true, message: 'This felid is required.', trigger: 'blur' },
                    ],
                }
			}
		},
		mounted(){
            console.log(this.userInfo);
            console.log(localStorage);
		},
		methods:{
			
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
    

    
	
</style>
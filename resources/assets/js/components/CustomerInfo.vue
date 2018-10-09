<template>
	<div class='adminPage'>
        
		<div v-if="hasInfo" class='container adminMain' >
            <div class="userNav">
                <div class="list-group">
                    <a href="/GLAAdmin" class="list-group-item" v-if="user.level==1">Admin Panel</a>
                    <router-link to='/CustomerInfo/HomePage' tag='a' class="list-group-item">My Account </router-link>
                    <router-link to='/CustomerInfo/OrderHistory' tag='a' class="list-group-item">Order History <span v-if="orderHistory" class='num'>({{orderHistory.length}})</span></router-link>
                    <router-link to='/CustomerInfo/PendingOrder' tag='a' class="list-group-item">Pending Order <span v-if="pending" class='num'>({{pending.length}})</span></router-link>
                    <router-link to='/CustomerInfo/HomePage' tag='a' class="list-group-item">Track My Order</router-link>
                    <router-link to='/CustomerInfo/HomePage' tag='a' class="list-group-item">Submit Inquiry</router-link>
                    <router-link to='/CustomerInfo/ChangeProfile' tag='a' class="list-group-item">Edit Profile </router-link>
                    <router-link to='/CustomerInfo/ChangePassword' tag='a' class="list-group-item">Change Password </router-link>
                </div>
            </div>
            <div class="userContent">
                <router-view></router-view>  
            </div>
        </div>

        <!-- if do not have details, please enter details first -->
        <div v-if="!hasInfo" class='user_details container text-center' >
            <div >
                <div class="alert alert-success text-left col-xs-12 col-sm-8 col-sm-offset-2">
                    Register a Golden Leaf Automotive account for a better shopping experience. You will be able to place order, check order status, 
                    shipping progress and fast and easy check out. If you don't have an account, please create a new one.
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <el-form  label-position="left" label-width="120px" :rules="rules" :model="details" ref="details" size="medium">
                    
                    <el-form-item label="Last Name" prop='surname'>
                        <el-input v-model="details.surname" placeholder="Last Name" ></el-input>
                    </el-form-item>

                    <el-form-item label="First Name" prop='forename'>
                        <el-input v-model="details.forename" placeholder="First Name"  ></el-input>
                    </el-form-item>

                    <div class="inRow">
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

                        <el-form-item label="Date of Birth" prop='brithday' >
                            <el-input type='date' v-model="details.brithday"   ></el-input>
                        </el-form-item>
                    </div>

                    <el-form-item label="Address" prop='address'>
                        <el-input v-model="details.address" placeholder="Address"  ></el-input>
                    </el-form-item>
                    
                    <div class="inRow">
                        <el-form-item label="City" prop='city'>
                            <el-input v-model="details.city" placeholder="City"  ></el-input>
                        </el-form-item>

                        <el-form-item label="Postal Code"  prop='zipcode'>
                            <el-input v-model="details.zipcode" placeholder="Postal Code" ></el-input>
                        </el-form-item>
                        
                    </div>

                    <div class="inRow">
                        

                        <el-form-item label="Country" prop='country'>
                            <!-- <el-input v-model="details.country" placeholder="Country" ></el-input> -->
                            <el-select v-model="details.country" placeholder="Country" @change='details.state=""'>
                                <el-option
                                v-for="item in country"
                                :key="item.name"
                                :label="item.name"
                                :value="item.Code">
                                </el-option>
                            </el-select>
                        </el-form-item>

                        
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

                        <el-form-item label="Province" prop='state' v-if="details.country=='USA'">
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

                    

                    <el-form-item label="Tel" prop='tel'>
                        <el-input type='number' v-model="details.tel" placeholder="Tel"></el-input>
                    </el-form-item>
                
                    <el-form-item label="Mobile" prop='mobile'>
                        <el-input type='number' v-model="details.mobile" placeholder="Mobile"  ></el-input>
                    </el-form-item>

                    <div class="inRow" >

                        <el-form-item label="Car" prop='car' label-width="120px">
                            <el-input v-model="details.car" placeholder="Make" ></el-input>
                        </el-form-item>
                        
                        <el-form-item  prop='education' label-width="10px" >
                            <el-select v-model="details.year" placeholder="Year">
                                <el-option
                                v-for="item in myRange(1949, year)"
                                :key="item"
                                :label="item"
                                :value="item" >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    
                        <el-form-item   prop='job'  label-width="10px" >
                            <el-input v-model="details.make" placeholder="Model" ></el-input>
                        </el-form-item>
                        <!-- <el-form-item   prop='tit'  label-width="10px" >
                            <el-input v-model="details.tit" placeholder="Model"  ></el-input>
                        </el-form-item> -->

                    </div>

                    
                    <el-form-item>
                        <el-button type='default' @click="resetForm(details)">Reset</el-button>
                        <el-button type="success" @click="submitForm(details)">Complate </el-button>
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
                
                
                US_states:[
                    {
                        "name": "Alabama",
                        "abbreviation": "AL"
                    },
                    {
                        "name": "Alaska",
                        "abbreviation": "AK"
                    },
                    {
                        "name": "American Samoa",
                        "abbreviation": "AS"
                    },
                    {
                        "name": "Arizona",
                        "abbreviation": "AZ"
                    },
                    {
                        "name": "Arkansas",
                        "abbreviation": "AR"
                    },
                    {
                        "name": "California",
                        "abbreviation": "CA"
                    },
                    {
                        "name": "Colorado",
                        "abbreviation": "CO"
                    },
                    {
                        "name": "Connecticut",
                        "abbreviation": "CT"
                    },
                    {
                        "name": "Delaware",
                        "abbreviation": "DE"
                    },
                    {
                        "name": "District Of Columbia",
                        "abbreviation": "DC"
                    },
                    {
                        "name": "Federated States Of Micronesia",
                        "abbreviation": "FM"
                    },
                    {
                        "name": "Florida",
                        "abbreviation": "FL"
                    },
                    {
                        "name": "Georgia",
                        "abbreviation": "GA"
                    },
                    {
                        "name": "Guam",
                        "abbreviation": "GU"
                    },
                    {
                        "name": "Hawaii",
                        "abbreviation": "HI"
                    },
                    {
                        "name": "Idaho",
                        "abbreviation": "ID"
                    },
                    {
                        "name": "Illinois",
                        "abbreviation": "IL"
                    },
                    {
                        "name": "Indiana",
                        "abbreviation": "IN"
                    },
                    {
                        "name": "Iowa",
                        "abbreviation": "IA"
                    },
                    {
                        "name": "Kansas",
                        "abbreviation": "KS"
                    },
                    {
                        "name": "Kentucky",
                        "abbreviation": "KY"
                    },
                    {
                        "name": "Louisiana",
                        "abbreviation": "LA"
                    },
                    {
                        "name": "Maine",
                        "abbreviation": "ME"
                    },
                    {
                        "name": "Marshall Islands",
                        "abbreviation": "MH"
                    },
                    {
                        "name": "Maryland",
                        "abbreviation": "MD"
                    },
                    {
                        "name": "Massachusetts",
                        "abbreviation": "MA"
                    },
                    {
                        "name": "Michigan",
                        "abbreviation": "MI"
                    },
                    {
                        "name": "Minnesota",
                        "abbreviation": "MN"
                    },
                    {
                        "name": "Mississippi",
                        "abbreviation": "MS"
                    },
                    {
                        "name": "Missouri",
                        "abbreviation": "MO"
                    },
                    {
                        "name": "Montana",
                        "abbreviation": "MT"
                    },
                    {
                        "name": "Nebraska",
                        "abbreviation": "NE"
                    },
                    {
                        "name": "Nevada",
                        "abbreviation": "NV"
                    },
                    {
                        "name": "New Hampshire",
                        "abbreviation": "NH"
                    },
                    {
                        "name": "New Jersey",
                        "abbreviation": "NJ"
                    },
                    {
                        "name": "New Mexico",
                        "abbreviation": "NM"
                    },
                    {
                        "name": "New York",
                        "abbreviation": "NY"
                    },
                    {
                        "name": "North Carolina",
                        "abbreviation": "NC"
                    },
                    {
                        "name": "North Dakota",
                        "abbreviation": "ND"
                    },
                    {
                        "name": "Northern Mariana Islands",
                        "abbreviation": "MP"
                    },
                    {
                        "name": "Ohio",
                        "abbreviation": "OH"
                    },
                    {
                        "name": "Oklahoma",
                        "abbreviation": "OK"
                    },
                    {
                        "name": "Oregon",
                        "abbreviation": "OR"
                    },
                    {
                        "name": "Palau",
                        "abbreviation": "PW"
                    },
                    {
                        "name": "Pennsylvania",
                        "abbreviation": "PA"
                    },
                    {
                        "name": "Puerto Rico",
                        "abbreviation": "PR"
                    },
                    {
                        "name": "Rhode Island",
                        "abbreviation": "RI"
                    },
                    {
                        "name": "South Carolina",
                        "abbreviation": "SC"
                    },
                    {
                        "name": "South Dakota",
                        "abbreviation": "SD"
                    },
                    {
                        "name": "Tennessee",
                        "abbreviation": "TN"
                    },
                    {
                        "name": "Texas",
                        "abbreviation": "TX"
                    },
                    {
                        "name": "Utah",
                        "abbreviation": "UT"
                    },
                    {
                        "name": "Vermont",
                        "abbreviation": "VT"
                    },
                    {
                        "name": "Virgin Islands",
                        "abbreviation": "VI"
                    },
                    {
                        "name": "Virginia",
                        "abbreviation": "VA"
                    },
                    {
                        "name": "Washington",
                        "abbreviation": "WA"
                    },
                    {
                        "name": "West Virginia",
                        "abbreviation": "WV"
                    },
                    {
                        "name": "Wisconsin",
                        "abbreviation": "WI"
                    },
                    {
                        "name": "Wyoming",
                        "abbreviation": "WY"
                    }
                ],
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
                orderHistory:[],
                pending:[],
                country:[
                        {name:'Canada',Code:"CA"},
                        {name:'USA',Code:"USA"},
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
                    country:'CA',
                    tel:'',
                    mobile:'',
                    car:'',
                    year:'',
                    make:'',
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
                        { required: true, message: 'Zip Code is required.', trigger: 'blur' },
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
                    
                }
			}
        },
        
        
		mounted(){
            // this.userInfo = JSON.parse(this.storage.getItem('userInfo'));
            
            // console.log(isValidZip);
            this.user = JSON.parse(this.storage.getItem('user'));

            if (this.user) {
                console.log('login');
            }else{
                this.$router.push({name:'Login'});
                console.log('not');

                return false;
            }
            this.details.surname = this.user.lastname;
            this.details.forename = this.user.firstname;
            this.userInfo = JSON.parse(this.storage.getItem("userInfo"));
            if (this.userInfo) {
                this.hasInfo=true;
            }else{
               
                this.hasInfo=false;
            }

            this.customerOrderHistory();
            
		},
		methods:{
            isAlphaOrParen(a) {
                return /^[a-zA-Z()]+$/.test(a);
            },
            submitForm(details){
                
               
                this.$refs["details"].validate((valid)=>{
                    if (valid){
                        if (this.details.country=='USA') {
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
                            this.$router.push({path:'/CustomerInfo/HomePage'});
                        
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
            },
            resetForm(details){
                this.$refs["details"].resetFields();
            },

            myRange(start,end){
                let ar = [];
                let l = parseInt(end)-parseInt(start);
                for (let i = 0; i <= l; i++) {
                    ar[i] = start;
                    start++;
                }
                return ar;
            }
                
        },

        computed:{
            year(){
                return (new Date()).getFullYear();
            }
        }


        
	}
</script>

<style scoped>
    .adminMain{
        padding: 0;
        display: flex;
        justify-content: space-between;
    }
	.adminPage{
       margin: 30px 0;
    }
    .adminPage{
        display: flex;
    }
    .userNav{
        width: 30%;
    }
    .userContent{
        width: 65%;
    }
    .userNav{
        background-color: black;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        padding: 30px 0;
        
    }
    
    .list-group,.list-group-item{
        color: white;
        background-color: black;
        border-color: black;
    }
    .inRow{
        display: flex;
        justify-content: space-between;
    }
    .num{
        font-weight: bold;
        color: red;
    }

    
	
</style>
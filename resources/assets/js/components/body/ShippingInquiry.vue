<template>
	<div class='container'>
		<div class="title">
			<span>Shipping Cost Inquiry</span>
		</div>
		<div v-if="success" style='margin-top:30px;'>
			<el-alert
				title="Thank you for your email, GLA will contact you as soon as possible."
				type="success"
				show-icon>
			</el-alert>
		</div>
		<div class='form-word col-xs-12'>
			<a class='back' @click="$router.push({name:'ItemDetails',params:{id:item.item}})">Back to Item</a><br>
			Please enter all necessary fields in the form below, and click on "Submit" to send your inquiry.
			If you would like to request our Catalog CD, please provide us your Mailing Address in the content box. 
		</div>
		<div class='form-word col-xs-12'>
			Item: {{item.item}} <br>
			Make: <span v-for="make in item_makes" :key="make.row_id"> {{make.make}} </span><br>
			Year: {{item.year_from}} -- {{ item.year_end }}
		</div>
		<div class="form  col-xs-12" >
				<el-form ref="form" :model="email" label-width="80px" :rules="rules" size='mini'>
					<el-form-item label="Name" prop='name'>
						<el-input v-model="email.name" placeholder="Name"></el-input>
					</el-form-item>
					<el-form-item label="Email" prop='email'>
						<el-input v-model="email.email" placeholder="Email"></el-input>
					</el-form-item>
					<el-form-item label="Subject" prop='subject'>
						<el-input v-model="email.subject" placeholder="Subject"></el-input>
					</el-form-item>

					<el-form-item label="Message" prop='messege'>
						<el-input
							type="textarea"
							:rows="6"
							placeholder="Leave messages"
							v-model="email.messege">
						</el-input>
					</el-form-item >
					<el-form-item>
						<div  class='btnArear'>
							<div id="myCaptcha"></div>
							<div>
								<el-button type='success' @click="sendMessage()"> Send Messege </el-button>
							</div>
						</div>
						
					</el-form-item>
					
				</el-form>
			</div>
		
	</div>
</template>

<script>
	export default{
		data(){
			return {
				myCap:false,
				success:false,
				item:[],
				item_makes:[],
				id:this.$route.params.item,
				email:{
					
				},
				rules:{
					name:[
						{ required: true, message: 'Name is required.', trigger: 'blur', max:99 }
					],
					email:[
						{ required: true, message: 'Email address is required.', trigger: 'blur', max:99 },
						{ type: 'email', message: 'Please input valid email address.', trigger: 'blur', max:99 }
					],
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
			let recaptchaScript = document.createElement('script')
                recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit" async defer')
				document.head.appendChild(recaptchaScript)
				
			this.$http.get('/api/item/'+ this.id).then(response => {
			    // get body data
				this.item = response.body.singleItem;
				
				this.item_makes = response.body.item_makes;
				
			  }, response => {
			  
			  });
		},

		methods:{
			sendMessage(){
            	this.$refs["form"].validate((valid)=>{
                    if(valid){
						/** check captcha */
                        this.$http.post('/api/checkCaptcha',{
                            'response':window.localStorage.getItem('captcha'),
                        },{emulateJSON: true}).then((response)=>{
                            
                            if (response.data.resp.success==true||this.myCap==true) {
                                window.localStorage.removeItem('captcha');
                                this.myCap = true;
								/**	main action */
								this.$http.post('/api/inquiryOnline',{
									subject:this.email.subject,
									name:this.email.name,
									email:this.email.email,
									messege:"Hello, I want to inquiry about item "+ this.item.item +" "+ this.email.messege,
								}).then(response=>{
									if (response.data.status) {
										this.success = true;
										this.email.name = '';
										this.email.email = '';
										this.email.subject = '';
										this.email.messege = '';
									}
								});
								/**	main action ends */
						
							}else{

							this.$message.error('Please check the Captcha box.');
							
							return false;
						}
					})

								
					/**	this is validate elase */	
                    }else{
                        
                    }
            })
        }
		}
		
	}
</script>

<style scoped>
	.title{
		margin-top: 10px;
		background-color: black;
		padding: 5px 20px;

	}
	.back{
		cursor: pointer;
	}
	.title span{
		font-size: 1.5em;
		color: white;
		font-weight: bold;
	}

	.form{
		margin: 30px 0;
	}

	.form-word{
		margin-top: 30px;
		font-size: 14px;
		font-weight: bold;
	}
</style>
<template>
	<div class='container'>
		<div class="title">
			<span>Contact Us</span>
		</div>
		<div class="map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2880.8862318308334!2d-79.6354286482207!3d43.77522039624773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b3b4cdc066897%3A0x3b04eb8c2646914d!2s170+Zenway+Blvd+%232%2C+Woodbridge%2C+ON+L4H+2Y7!5e0!3m2!1sen!2sca!4v1514931686154" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>

		<div v-if="success" style='margin-top:30px;'>
			<el-alert
				title="Thank you for your email, GLA will contact you as soon as possible."
				type="success"
				show-icon>
			</el-alert>
		</div>
		<div class="address">
			<div class="col-xs-6 address_details" style='height:387px;'>
				<div>
					<span style='font-size:24px'>CONTACT US</span>
				</div>
				<div>
					<table class='table address_table'>
						<tr>
							<td>
								ADDRESS:
							</td>
							<td>
								170 Zenway Blvd. Unit 2<br> Woodbridge, ON., L4H 2Y7 CANADA
							</td>
						</tr>

						<tr>
							<td>
								TELEPHONE:
							</td>
							<td>
								905-850-3433
							</td>
						</tr>

						<tr>
							<td>
								FAX:
							</td>
							<td>
								905-850-1722
							</td>
						</tr>

						<tr>
							<td>
								BUSINESS HOURS:
							</td>
							<td>
								Monday-Friday: 8:30am-5pm <br>Saturday: Appointment Only
							</td>
						</tr>
					</table>
				</div>
				<div class="img">
					<img src="/images/loc_01.jpg" alt="">
				</div>
			</div>
			<!-- <div class="words col-xs-6" >
				<table>
					<tr>
						<td class='left'>ADDRESS <span class='glyphicon glyphicon-play'></span>	</td>
						<td class='right'>170 Zenway Blvd. Unit 2<br>		
						Woodbridge, ON., L4H 2Y7 CANADA</td>
					</tr>
					<tr>
						<td class='left' >TELEPHONE<span class='glyphicon glyphicon-play'></span></td>
						<td class='right'>905-850-3433</td>
					</tr>
					<tr>
						<td class='left' >FAX<span class='glyphicon glyphicon-play'></span></td>
						<td class='right'>905-850-1722</td>
					</tr>
					
					
					<tr>
						<td class='left' >BUSINESS HOURS<span class='glyphicon glyphicon-play'></span></td>
						<td class='right'>	Monday-Friday: 8:30am-5pm <br>
							Saturday: Appointment Only</td>
					</tr>
				</table>
				<div class="img">
					
				</div>
			</div> -->

			<div class="form col-xs-6" >
				
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
		
	</div>
</template>
<script>
	export default {
		data(){
			return {
				myCap:false,
				success:false,
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
									messege:this.email.messege,
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
	map{
		width:100%;	

	}
	.title{
		margin-top: 10px;
		background-color: black;
		padding: 5px 20px;

	}
	.title span{
		font-size: 1.5em;
		color: white;
		font-weight: bold;
	}
	.address{
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
		margin-bottom: 30px;
		margin-top: 30px;
		vertical-align: top;
		
	}
	.img{
		display: flex;
		flex-direction: column;
		text-align: right;


	}
	.sub_title{
		font-size: 1.5em;
		font-weight: bold;
		padding: 20px 0;
		color: black;
	}
	.left{
		padding-right: 10px;
		text-align: right;
		color: black;
		font-size: 1em;


	}
	.right{
		text-align: left;
	}
	.form{
		
	}
	.words{
	}
	.button{
		width: 120px;
	}
	.btnArear{
		display: flex;
		flex-direction: row;
		align-items: flex-end;
		justify-content: space-between;
	}
	.address_table td{
		padding:1px 0;
		font-size: 16px;
		vertical-align: top !important;
	}
	.address_details{
		/* display: flex;
		flex-direction: column;
		justify-content: space-between; */

	}
</style>
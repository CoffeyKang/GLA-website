<template>
	<div class='container'>
		<div class="title">
			<span>Contact Us</span>
		</div>
		<div class="map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2880.8862318308334!2d-79.6354286482207!3d43.77522039624773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b3b4cdc066897%3A0x3b04eb8c2646914d!2s170+Zenway+Blvd+%232%2C+Woodbridge%2C+ON+L4H+2Y7!5e0!3m2!1sen!2sca!4v1514931686154" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
		<div class="address ">
			<div class="words ">
				
				<table class='table'>
					<tr>
						<td class='left'>ADDRESS <span class='glyphicon glyphicon-play'></span>	</td>
						<td class='right'>70 Zenway Blvd. Unit 2	<br>		
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
						<td class='left' >EMAIL<span class='glyphicon glyphicon-play'></span></td>
						<td class='right'>Click Here</td>
					</tr>
					<tr>
						<td class='left' >WEBSITE<span class='glyphicon glyphicon-play'></span></td>
						<td class='right'>http://www.goldenleafautomotive.com</td>
					</tr>
					<tr>
						<td class='left' >BUSINESS HOURS<span class='glyphicon glyphicon-play'></span></td>
						 <td class='right'>	Monday-Friday: 8:30am-5pm <br>
							Saturday: Appointment Only</td>
					</tr>
				</table>
				<div class="img">
					<img src="/images/loc_01.jpg" alt="">
				</div>
			</div>
			<div class="form">
				<form action="#" class='form-horizontal'>
					

					<div class="form-group ">
						<div class="col-xs-6">
							<label for="phone" class='control-label'>Phone Number</label>
						
						<input type="text" class="form-control" id="phones" placeholder="Your Phone Number">
						</div>
						

						<div class="col-xs-6">
							<label for="name" class='control-label'>Name</label>
							<input type="text" class="form-control" id="name" placeholder="Your Full Name">
						</div>
    					
					</div>

					

					<div class="form-group">
						<div class="col-xs-12">
							<label for="email" class='control-label'>Email address</label>
							<input type="email" class="form-control" id="email" placeholder="Your Email">
    					</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12">
							<label for="message" class='control-label'>Message</label>
							<textarea class="form-control" id='message' rows="3" placeholder="Message"></textarea>
    					</div>
					</div>

					<div class="form-group text-right">
						
						<button type='reset' class="btn btn-primary">
							Reset	
						</button>
						<button type='submit' class="btn btn-success">
							Send Message
						</button>
    					
					</div>
				</form>
			</div>
			
		</div>
		
	</div>
</template>

<script>
	
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
		width:500px;
		padding: 30px;
	}
	.words{
		width: 500px;
		padding: 30px;
	}
	.
	button{
		width: 120px;
	}
</style>
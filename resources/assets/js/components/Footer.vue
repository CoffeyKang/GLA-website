<template>
	<div class="gla-footer">
		<div class="gla-footer-details">
			<div class='mobile_no'>
				<ul>
					<router-link to='/' tag='li' class='footer-title' exact><a>Customer Service</a></router-link>
					<router-link to='/allProducts' tag='li' ><a>All Products</a></router-link>
					<router-link to='/catalog' tag='li' ><a>Catalog</a></router-link>
					<router-link to='/classicBody' tag='li' ><a>Classic Body</a></router-link>
					<router-link to='/Dealer' tag='li' ><a>Dealers Area</a></router-link>
					<router-link to='/contact' tag='li' ><a>Contact</a></router-link>
					<router-link to='/special' tag='li' ><a>Special</a></router-link>
				</ul>
			</div>
			<div  class='mobile_no'>
				<ul>
					<li class='footer-title'>My Account</li>
					<li v-if="!loginStatus" @click="goto('Login')">Login / Register</li>
					<li v-if="loginStatus" @click="goto('userHome')">My Account</li>
					<li @click="goto('Dealer')">Dealers Login</li>

				</ul>
			</div>
			<div class='mobile_no'>
				<ul>
					<li class='footer-title'>Shopping Policies</li>
					<router-link to='/policy/price' tag='li'> Pricing Policy</router-link>
					<router-link to='/policy/returnPolicy' tag='li'> Return Policy</router-link>
					<router-link to='/policy/shipping' tag='li'> Shipping and Delivery</router-link>
					<router-link to='/policy/warranty' tag='li'> Warranty and Damage</router-link>
				</ul>
			</div>
			<div class='payment'>
				<div class='mobile_no'>
					<img src="images/paymentOption.png" alt="payment_logo">
				</div>
				<div class='copyright'>
					&copy; 2018 Golden Leaf Automotive. All rights reserved.
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return {
				
			}
		},
		computed:{
			loginStatus:{
				get:function(){
					return this.$store.state.loginStatus;
				}
			}
		},

		mounted(){
			
		},

		methods:{
			goto(name_link){
				this.$router.push({name:name_link});
			}
		}
	}
</script>

<style scoped>
	@media screen and (min-width: 1200px){
		.gla-footer{
			display: flex;
			justify-content: center;
		}
		.gla-footer-details{
			width:1200px;
		}
	}
	@media screen and (min-width: 768px) {
		.gla-footer{
			background-color: black;
			color: white;
		}
		li{
			list-style: none;
			padding: 5px 0;
			font-size: 14px;
			cursor: pointer;
		}	
		.footer-title{
			font-size: 22px;
			font-weight: bold;
		}
		.gla-footer-details{
			display: flex;
			flex-direction: row;
			justify-content:space-between; 
			flex-wrap:nowrap ;
			padding: 30px 10px;
		}
		.payment{
			padding-top: 100px;
			display: flex;
			flex-direction: column;
		}
		.copyright{
			padding-top: 20px;
			font-size: 14px;
		}
		a{
			color:white;
			text-decoration: none;
		}
		a:hover{
			color:white;
		}	
	}

	@media screen and (max-width: 768px) {
		/*mobile footer empty now*/
		.gla-footer{
			background-color: black;
			color: white;
			text-align: center;
		padding: 30px 0;

		}
		.mobile_no{
			display: none;
		}
		
		
	}

	
</style>
<template>
	<div>
		<div class="container">
			<div class="title">
				<span>{{title}}</span>
			</div>
		</div>
		<div class="container">
			<div class="price container" v-if="price">

			
					
						<h4>Catalog Pricing</h4>
						<p>
							All prices are current and in effect at the time of printing.<br>

							Golden Leaf Automotive reserves the right to adjust pricing and availability as needed.<br>

							This catalog supersedes all previous catalogs published. OEM parts numbers are for reference only.<br>
						</p>
			</div>
			<div class="returnPolicy container" v-if="returnPolicy">
						<h4>Refused Shipments</h4>
						<p>
							Shipping and other costs incurred by GLA while attempting to deliver merchandise which is refused will be billed 
							to the customer at the actual cost. Items Damaged in transit are the responsibility of the carrier. Please retain 
							all packing materials and immediately contact the courier (i.e., UPS, FedEx, DHL, U.S. Postal Service, Canada Post, 
							truck line) to file a damage claim. Please do not return damaged items to GLA. We will, however, be happy to assist 
							you in filing your claim with the carrier.
						</p>
						<p>
							General policy on core returns:
							<ul>
								<li>No broken or missing parts, cracked cases, deeply grooved surfaces etc.</li>
								<li>Moveable items must not be frozen, locked or rusted solid.</li>
								<li>No case with torch cuts.</li>
								<li>No welded or bent shafts, ears etc.</li>
								<li>No disassembled cores accepted.</li>
								<li>Returned core must be same part as rebuilt unit purchased.</li>
								<li>Returned core should be returned in same box as rebuilt unit purchased.</li>
								<li>Core return-ability will be determined by the re-manufacturer and/or GLA.</li>
							</ul>
						</p>

						<h4>Returns - Our Guarantee</h4>
						<p>
							If you are dissatisfied with an item, please contact GLA to obtain return authorization. Missing or damaged items 
							must be reported within 24 hours of delivery . After speaking with us, we request that you also enclose a brief note 
							describing the problem with the returned merchandise. We will accept the return of any unsatisfactory item provided 
							it is unused, in resalable condition and returned with a copy of your invoice within 30 days of the invoice date. 
							Return of items ordered in error may be subject to a 25% restocking fee. Please do not return merchandise to 
							us C.O.D. or postage due. If GLA is at fault in any way we will promptly refund your return freight charges. 
							GLA is NOT responsible for air-freight charges or boxing/packing services. Only courier ground rates apply.
						</p>
			</div>	
					
				<div class="shipping container" v-if="shipping">
						<h4>Domestic Shipping Charges</h4>
						<p>
							GLA follows the following shipping procedures. <br>
							<b>BASIC SHIPPING: </b>DHL Groundtrack Delivery Service/Sameday Worldwide <br>
							<b>PREMIUM SHIPPING OFFERED:</b> Next Day (Air Service) <br>
							GLA Warehouse Trucking Companies used: <br>

							Sameday RightOWay, Vitran, Fastfreight. <br>

							Other companies used at your request. When requesting another freight line please have all information available. <br>

							<b>Optional shipping methods:</b><br>
							<b>
								UPS/FedEx/DHL 3 Day Guaranteed Ground, 2nd Day Air, Next Day Air, and parcel post shipping is available at 
								actual cost. Rates vary according to weight.
							</b>
						</p>
				</div>
					
				<div class="warranty container" v-if="warranty">

				
						<h4>Damage - Warranty & Damage Information</h4>
						<p>If, for any reason, you are not satisfied with the quality of any reproduction part purchased from us, 
							you may return it for a full refund within 30 days from the date of purchase. (Invoice date) If the part 
							fails for any reason (excluding chroming) you may return it to us (freight prepaid) with proof of purchase 
							for an immediate replacement. This warranty supercedes any other warranty expressed or implied.
						</p>
						<p>
							All packages should be inspected immediately upon delivery. The carrier should be notified as soon as possible 
							if there is any notable damage. Advise our sales staff of any shipping damage if the shipment was sent DHL, you have 
							3 days to notify us of any damage incurred. If shipped by LTL carrier (truck) you have 1 day to notify us of any 
							damage. As the frieght companies do not recognize hidden damage it is imperative you inspect your freight upon 
							arrival. Check the large easily damaged items if nothing else. If you do not, you could be liable for any damage 
							not noted on the freight bill.
						</p>
				</div>
		</div>
		
			
	</div>
		
</template>
<script>

	export default {
		data (){
			return {
				active:this.$route.params.detail,	
				returnPolicy:false,
				shipping:false,
				price:false,
				warranty:false,
			}
		},
		mounted(){
			
		},
		computed:{
			title(){
				var str = '';
				switch (this.active) {
					case 'price':
						str = "Pricing Policy";
						break;

					case 'returnPolicy':
						str = "Return Policy";
						break;
					
					case 'shipping':
						str = "Shipping and Delivery";
						break;
					
					case 'warranty':
						str = "Warranty and Damage";
						break;
					default:
						str = "Return Policy";
						break;
				}

				return str;
			}
		},
		mounted(){
			switch(this.$route.params.detail) {
					case 'price':
						this.price = true;
						break;

					case 'returnPolicy':
						this.returnPolicy = true;
						break;
					
					case 'shipping':
						this.shipping = true;
						break;
					
					case 'warranty':
						this.warranty = true;
						break;
					default:
						this.price = true;
						break;
				}
		},
		methods:{
			
			
			
			

			
			
		},
		
	}

	
</script>
<style scoped>
	
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
	
	p{
		text-align:justify;
		padding-right: 15px;
	}
	
	
	
	
	
</style>
<template>
	<div>
		<div class="img">	
			<img src="/images/img.jpg" alt="img">
		</div>
		<div class="words">
			
			<small>Product No: #123456</small>
			
			<span class='description'>Description</span>
			
			<small>Year Fit: 1990-1980</small>
			
			<small>Make: WHEEL</small>
			
			<span class='price'>$200.00</span>
			
			<button class="btn btn-primary">
				Details
			</button>
			

		</div>
	</div>
</template>

<script>
	
</script>

<style scoped>
	div{
		min-height: 100px;
	}
	img{
		width:90%;
	}
	.words{
		display: flex;
		flex-direction: column;
	}
	button{
		width:150px;
	}
	.price{
		color: red;
		font-size: 2em;
		font-weight: bold;
		padding: 10px 0 ;
	}
	.description{
		color: black;
		font-weight: bold;
		text-transform: uppercase;
	}
</style>
<template>
	<div class='item-panel'>
		<div class="img">	
			<img src="/images/products/thumb/104.jpg" alt="img">
		</div>
		<div class="words">
			
			<small>#123456</small>
			
			<small>Year Fit: 1990-1980</small>
			
			<small>Make: WHEEL</small>
			
			<span class='price'>Sale Price: <b>$200.00</b></span>

			<span class='description'>Description</span>
			
		</div>
		<div class='add_details'>
			<a href='#'>
				Add To Cart <span class='glyphicon glyphicon-shopping-cart'></span>
			</a>
			
			<a href='#'>
				Details <span class='glyphicon glyphicon-play'></span>
			</a>	
			
			
		</div>
	</div>
</template>

<script>
	
</script>

<style scoped>
	.item-panel{
		border-right: 1px solid gray;
		border-left: 1px solid gray;
		border-top: none;
		border-bottom: 1px dotted gray;
		width:270px;
		margin-bottom: 5px;
		margin-left: 10px;

	}
	.img{
		padding:20px;
	}
	img{
		width:100%;

	}
	.words{
		display: flex;
		flex-direction: column;
		text-align: center;


	}
	
	.price{
		color: red;
		font-size: 1em;
		padding: 10px 0 ;
	}

	.description{
		color: black;
		font-weight: bold;
		text-transform: uppercase;
	}
	.add_details{
		display: flex;
		justify-content: space-between;
		padding: 10px;
	}
	

</style>
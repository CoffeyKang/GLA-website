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
			<button class="btn btn-primary">
				Details
			</button>
			<a href='#' class='add_to_cart'>
				Add To Cart 
			</a>
			
				
			
			
		</div>
	</div>
</template>

<script>
	
</script>

<style scoped>
	.item-panel{
		
		border-top: none;
		border-bottom: 1px dotted gray;
		width:220px;
		margin-bottom: 15px;
		margin-right: 7px;

	}
	.img{
		padding:40px;
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

	button{
		width:100px;
	}

	.add_to_cart{
		display: flex;
		align-items: flex-end;
	}
	

</style>
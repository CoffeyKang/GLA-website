<template>
	<div class='container ccbd'>
		<div class="banner">
			<img src="/images/ccbd_header.jpg" alt="">
		</div>
		<div class="wards">
			<p>In the restoration car parts industry, Dynacorn International, Incorporated constantly strives to be the best at what we do. As we streamline the purchasing process and continue to strengthen our customer service, we make it easier and easier to get your parts from dii. With facilities on the East and West coasts and Canada, we are now prepared to meet your needs better than ever.</p>
		</div>
		<button class="btn btn-success" @click='change()'>
			click
		</button>
	</div>
</template>

<script>
	export default{
		methods:{
			change(){
				this.$store.commit('increment');
			}
		}
	}
</script>

<style scoped>
	.ccbd{
		display: flex;

	}
	.wards p{
		padding: 35px;
	}
</style>
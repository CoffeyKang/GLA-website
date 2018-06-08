<template>
	<div class='container'>
		<div class="title">
			<span>On Sale Products</span>
		</div>
		<div class='specialItems' >
			<div v-for='a in 7' :key="a">
				<app-special-item></app-special-item>
			</div>
		</div>
	</div>
</template>

<script>
	import SpecialItem from './parts/Special_item.vue';
	export default {
		components:{
			appSpecialItem:SpecialItem,
		}
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
	.specialItems{
		display: flex;
		justify-content:left;
		margin-top: 10px;
		flex-wrap: wrap;

	}
	
</style>
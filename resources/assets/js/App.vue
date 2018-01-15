<template>
	<div>
		<div class='container-fuild'>
            <app-header></app-header>
        </div>
        <div class='container-fuild' id='body'>
            <router-view></router-view>
        </div>
        <div class='container-fuild'>
            <app-footer></app-footer>
        </div>
        
	</div>
</template>

<script>
	/**
	 * components header and footer
	 */
	import Header from './components/Header.vue';
	import Footer from './components/Footer.vue';
	/**
	 * body conponents
	 * @type {Vue}
	 */
	import Home from './components/body/Home.vue';


	export default {
		components:{
			appHeader:Header,
			appFooter:Footer,
			appHome:Home,
		}
	}
</script>

<style scoped>
	#body{
		min-height: 700px;
	}
</style>
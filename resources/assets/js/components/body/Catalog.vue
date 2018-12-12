<template>
	<div class='container' style='margin-bottom:40px;'>
		<div class="title">
			<span>Catalog</span>
		</div>
		<div class=" col-xs-12 col-sm-3 cat" v-for="catalog in catalogs" :key="catalog.id">
			<div class="cat_img" 
			:style="{ backgroundImage: 'url(/images/catalog/' + catalog.path + ')' }">
			</div>
			<div class="cat_btn">
				<h4 class='text-center' v-html="displayName(catalog.display)"></h4>
				<button class="btn btn-block viewOnline" @click="viewPDF(catalog.name)">
					View Online
				</button>
				<button class="btn btn-block download" @click="download(catalog.name)" >
					Download PDF
				</button>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data(){
			return {
				catalogs:[
				



				]
			}
		},
		mounted(){
			// get featureProducts
			this.$http.get('/api/catalogs').then(response=>{
				this.catalogs = response.body.catalogs;
			}, response=>{
				// error log
			});
		},
		methods:{
			download(name){
				window.open('/images/PDF/'+name+'.pdf');
			},
			
			viewPDF(name){
				window.localStorage.setItem('pdf_make',name);
				this.$router.push({name:'Booklet',params:{make:name}});
			},
			displayName(value){
				return value.replace(/&/,"<br>").toUpperCase();
			}
		},
		computed:{
			
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
		font-size: 20px;
		color: white;
		font-weight: bold;
	}
	.cat_img{
		height: 230px;
		background-position: center;
		background-size: contain;
		background-repeat: no-repeat;
	}
	.viewOnline{
		background-color: #FFE512;
		font-size: 20px;
	}
	.download{
		background-color: black;
		color: white;
		font-size: 20px;
	}
	h4{
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>
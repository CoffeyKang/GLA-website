<template>
	<div class='container' style='margin-bottom:40px;'>
		<div class="title">
			<span>Classic Body</span>
		</div>
		<div class='col-xs-12 cat'>
			<div class="banner col-xs-12 col-sm-6">
				<img src="/images/ccbd_header.jpg"  style=' width:100%' alt="">
			</div>

			<div class="banner col-xs-12 col-sm-6">
				<p>In the restoration car parts industry, Dynacorn International, Incorporated constantly strives to be the best at 
					what we do. As we streamline the purchasing process and continue to strengthen our customer service, 
					we make it easier and easier to get your parts from dii. 
					With facilities on the East and West coasts and Canada, we are now prepared to meet your needs better than ever.</p>
			</div>
		</div>
		




		<div class=" col-xs-12 col-sm-3 cat" v-for="i in 16" :key="i">
			<div class="cat_img" 
			:style="{ backgroundImage: 'url(/images/ccbd/classicBody-' + i + '.jpg)' }" @click="bigger(i)">
			</div>
		</div>

		<div class="col-xs-12 text-center">
			<button class="btn btn-success" @click='$router.push("/booklet/CLASSIC%20BODY")'>View Online</button>
		</div>
		
		<el-dialog
			:visible.sync="dialogVisible"
			custom-class='bigpic'
			width=55%
			>
			<span style='margin:auto;text-align:center'
			><img :src="imgSrc" alt="" style='width:100% '></span>
			
		</el-dialog>
	</div>
</template>

<script>
	export default{
		data(){
			return {
				dialogVisible:false,
				imgSrc:'',
			}
		},
		methods:{
			bigger(i){
				this.dialogVisible = true;
				i = i + 1;
				if (i<10) {
					i = '0'+i;
				}
				this.imgSrc = '/images/catalog/CLASSIC BODY/CLASSIC BODY_Page_' + i + '.jpg';
			}
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
	.cat{
		padding: 20px 0;
		
	}
	.cat_img{
		
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
		height: 250px;
	}
	.cat_img:hover{
		cursor: pointer;
		border: 10px solid white;
	}

	.banner
{
	height: 180px;
}
.banner p{
	padding-top: 25px;

}
</style>
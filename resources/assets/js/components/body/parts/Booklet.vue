<template>
	<div class='container'>
        <div class='searchBar'>
            <app-search ></app-search>
        </div>
        <div class="viewOnline">
            <img :src="page" alt="" style='width:100%' @click='nextPage()'>
        </div>
        <div class='searchBar'>
            <app-search ></app-search>
        </div>
        <div class="btnBar">
            <span><button class="btn btn-primary" @click='previousPage()'>Previous Page</button></span>
            <span>
                <el-input v-model='num' id='numInput' style='width:60px;'></el-input> / <el-input :value='total' style='width:60px; ' readonly="readonly"></el-input>
            </span>
            <span><button class="btn btn-primary" @click='nextPage()'>Next Page</button></span>
        </div>
    </div>
</template>

<script>
    import SearchBar from './SearchBar.vue';
	export default{
        data(){
            return {
                num:1,
                make:'',
                total :1,
                pic_array : [],
            }
        },
        computed:{
            page(){
                if (this.num>this.total ) {
                    this.num =1;
                }else{

                }

                if (isNaN(this.num) ) {
                    this.num =1;
                    $('#numInput').val(1);
                }else{

                }

                var n = this.pic_array[this.num-1];
                // var pageNum = '/images/catalog/'+this.make+'/2018 GLA '+this.make+'Catalog_Page_'+n+'.jpg';
                return n;
            }
        },
        components:{
          appSearch:SearchBar
        },
        watch: {
            
        },
        methods:{
            nextPage(){
                if (this.num<this.total) {
                    this.num++;
                }else{
                    this.$message({
                        message:'This is the last page',
                        type:'warning'
                    })
                }
            },
            
            previousPage(){
                if (this.num>1) {
                    this.num--;
                }else{
                    this.$message({
                        message:'This is the first page',
                        type:'warning'
                    })
                }
            },

           
        },
       
        mounted(){
            this.make = window.localStorage.getItem('pdf_make');
            this.$http.get('/api/getFileNumbers/'+this.make).then((response)=>{
                this.total = response.data.pageNum;
                this.pic_array = response.data.pic_array;
            });
        },
        
		
	}
</script>

<style scoped>
	.searchBar{
        background-color: black;
        padding: 10px 0;
    }

    .btnBar{
        margin: 10px;
        display: flex;
        justify-content: center;
        
    }

    .btnBar span{
        margin: 0 10px;
    }

    .viewOnline{
        height: 1475px;
        background-color: lightgray;
        
    }
    

</style>
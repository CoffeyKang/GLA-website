<template>
	<div class="searchBar">
       <form class='searchForm'>
                    <div class='words'>
                    	I NEED TO FIND:
                    </div>

                    <div class="inputSearch">
                    
	                    <el-input v-model="search.item" placeholder="Enter a specific part, ie. Fender, Hood, Lamp, etc."></el-input>
						<div class='mySelect'>
	                    <el-select v-model="search.make" placeholder="Make" style='width:120px;'>
	                    	<el-option
						      v-for="item in makes"
						      :key="item.id"
						      :label="item.make"
						      :value="item.make">
						    </el-option>

	                    </el-select >
						</div>
						<div class='mySelect'>	
	                    <el-select v-model="search.year" placeholder="Year" style='width:120px;'>
	                    	<el-option
						      v-for="a in (currentYear)"
						      :key="a"
						      :label="a"
						      :value="a"			
						      v-if="a>1949">
						    </el-option>
	                    </el-select >
	                    </div>
	                    
	                <button class='btn btn-primary findBTN' @click='searchItem()'>FIND</button>

                </div>
                  
            </form>
        </div>
</template>

<script>

	export default{
		data(){
			return {
				search:{},
				makes:{},
				sr:{},
				currentYear:new Date().getFullYear(),
			}
		},
		mounted(){
			this.$http.get('/api/makes').then(response => {
			    // get body data
			    this.makes = response.body;
			    console.log(this.makes);
			  }, response => {
			  	// error 
			    console.log("error");
			  });
		},
		methods:{
			searchItem(){
				this.$http.get('/api/searchResualt', 
					{params:
						{
							item:this.search.item, 
							make:this.search.make,
							year:this.search.year,
						}
						}).then(response => {
			    // get body data
			    this.sr = response.body;
			    console.log(this.sr);
			    
			    if (this.sr=='itemFound') {
			    	this.$router.push({name:'ItemDetails',params:{id:this.search.item}})

			    }else if(this.sr.data.length>=2){
			    	
			    	this.$router.push({name:'SearchResualt',query:{make:this.search.make, year:this.search.year}})
			    }else{
			    	alert('not such item fond');
			    }
			    
			  }, response => {
			  	// error 
			    console.log("error");
			  });
			}
		}

		
	}
</script>

<style scoped>
	.searchForm{
      width: 80%;
      margin: auto;
      display: flex;
      justify-content: space-around;
      color: white;
      
    }
    .inputSearch{
    	display: flex;
    	justify-content: space-around;
    }
    .words{
    	width: 20%;
    	font-weight: bold;
    	line-height: 40px;
    	align-items: center;
    	font-size: 1.2em;

    }
    .findBTN{
      margin-left: 20px;
      height: 40px;
      padding-left: 20px;
      padding-right: 20px;
      line-height: 30px;
    }
    .inputSearch{
    	width: 80%;
    }
    .mySelect{
    	margin-left: 20px;
    }

</style>
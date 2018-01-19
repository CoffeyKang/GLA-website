<template>
	<div class="searchBar">
    	<el-form label-width="80px" size="medium">
			
			<el-form-item label="Item" >
		    	<el-input v-model="search.item" placeholder="Enter a specific part, ie. Fender, Hood, Lamp, etc." style='width:350px;'>
		    	</el-input>
			</el-form-item>

		  	<el-form-item label="Make" >
				
				<el-select v-model="search.make" placeholder="Make" style='width:350px;'>
	                <el-option
				      v-for="item in makes"
				      :key="item.make"
				      :label="item.make"
				      :value="item.make">
				    </el-option>

	            </el-select >		    
		    </el-form-item>

		    <el-form-item label="Year" >
		  	    <el-select v-model="search.year" placeholder="Year" style='width:350px;'>
	                <el-option
					  v-for="a in (currentYear)"
					  :key="a"
					  :label="a"
					  :value="a"			
					  v-if="a>1949">
					</el-option>
	            </el-select >  
		    </el-form-item>
	  	
		  	<el-form-item>
		    	<el-button type="primary" @click="searchItem()">Search</el-button>
		    	<el-button @click='resetSearch()'> Reset </el-button>
		  	</el-form-item>
		</el-form>
            


                    
	                    
	                
                  
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

				this.$emit('closeSearchLayer',false);
			},

			resetSearch(){
				return this.search={};
			}
		}

		
	}
</script>

<style scoped>

</style>
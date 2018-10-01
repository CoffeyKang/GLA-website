<template>
	<div class="searchBar" @keyup.enter="searchItem()">
		<!-- search layer -->
		<div class='searchDetails'>
			<span class="searchTitle">I am searching for:</span>
			<el-form label-width="80px" size="medium" >
				<el-form-item label="Item" >
					<el-input v-model="search.item" placeholder="Enter a specific item number, ie. 1000A " 
					style='width:350px;' >
					</el-input>
				</el-form-item>

				<el-form-item label="Keywords" >
					<el-input v-model="search.desc" placeholder="Enter a specific part, ie. Fender, Hood, Lamp, etc." style='width:350px;'>
					</el-input>
				</el-form-item>
				

				<el-form-item label="Make" >
					
					<el-select v-model="search.make" placeholder="Make" style='width:350px;'>
						<el-option
						v-for="item in makes"
						:key="item.id"
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
		<div class='searchCatalog'>
			<span class="searchTitle">Search by Catalog:</span>
			<div class="img">

			</div>
			<div class="btn_div">
				<el-form label-width="80px" size="medium" >
				
					<el-form-item label="Make" >
						
						<el-select v-model="search.make" placeholder="Make" style='width:350px;'>
							<el-option
							v-for="item in makes"
							:key="item.id"
							:label="item.make"
							:value="item.make">
							</el-option>

						</el-select >		    
					</el-form-item>
					
					<el-form-item>
						<el-button type="primary" @click="searchItem()">Search</el-button>
						<el-button @click='resetSearch()'> Reset </el-button>
					</el-form-item>
				</el-form>
			</div>
		</div>
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
				checkInput:false,
			}
		},
		mounted(){
			this.$http.get('/api/makes').then(response => {
			    // get body data
			    this.makes = response.body;
			    
			  }, response => {
			  	// error 
			    console.log("error");
			  });
		},
		methods:{
			searchItem(){
				
				this.$router.push({name:'SearchList',query:{
							item:this.search.item, 
							make:this.search.make,
							year:this.search.year,
							desc:this.search.desc,
						}});

				this.$emit('closeSearchLayer',false);
			},
			resetSearch(){
				return this.search={};
			}
		},
		watch: {
			
				
		}

	}
</script>

<style scoped>
	.searchBar{
		display: flex;
		justify-content: space-between;
	}
	.searchTitle{
		font-weight: bold;
		text-align: center;
		font-size: 20px;
		padding-bottom: 20px;
		width: 100%;
	}

	.searchCatalog{
		display: flex;
		width: 50%;
		flex-direction: column;
		border-left: 1px solid black;
	}

	.searchDetails{
		width: 50%;
		display: flex;
		flex-direction: column;
	}

	.img{
		background-image: url('/images/catalogSearch.jpg');
		background-position: center;
		background-size: contain;
		height: 160px;
		background-repeat: no-repeat;
		margin-bottom:30px;
		
	}
</style>
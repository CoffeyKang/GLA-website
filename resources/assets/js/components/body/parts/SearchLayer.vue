<template>
	<div class="searchBar" @keyup.enter="searchItem()">
		<!-- search layer -->
		<div class='searchDetails cat1'>
			<span class="searchTitle">I am searching for:</span>
			<el-form label-width="80px" size="medium" >
				<el-form-item label="Item" >
					<el-input v-model="search.item" placeholder="Enter a specific item number, ie. 1000A " 
					>
					</el-input>
				</el-form-item>

				<el-form-item label="Keywords" >
					<el-input v-model="search.desc" placeholder="Enter a specific part, ie. Fender, Hood, Lamp, etc." >
					</el-input>
				</el-form-item>
				

				<el-form-item label="Make" >
					
					<el-select v-model="search.make" placeholder="Make" >
						<el-option
						v-for="item in makes"
						:key="item.id"
						:label="item.make.replace('_',' ').toUpperCase()"
						:value="item.make">
						</el-option>

					</el-select >		    
				</el-form-item>

				<el-form-item label="Year" >
					<el-select v-model="search.year" placeholder="Year" >
						<el-option
						v-for="a in (currentYear)"
						:key="a"
						:label="a"
						:value="a"			
						v-if="a>1949">
						</el-option>
					</el-select >  
				</el-form-item>
				<el-form-item class='searchBtn'>
					<el-button type="primary" @click="searchItem()">Search</el-button>
					<el-button @click='resetSearch()'> Reset </el-button>
				</el-form-item>
			</el-form>
		</div>
		<div class='searchCatalog cat2'>
			<span class="searchTitle">Search by Catalog:</span>
			<span class='searchTitle_D'>
				If you don't know the particular <b>Part Name</b> or <b>Item Number</b>, you may search by browsing our online catalogue.
				Please select your desired <b>Make</b> from the menu selection below:
			</span>
			<div class="img">

			</div>
			<div class="btn_div">
				<el-form label-width="80px" size="medium" >
				
					<el-form-item label="Make" >
						
						<el-select v-model="cat_make" placeholder="Make" >
							<el-option
							v-for="item in catalogs"
							:key="item.id"
							:label="displayName(item.display)"
							:value="item.name">
							</el-option>

						</el-select >		    
					</el-form-item>
					
					<el-form-item class='searchBtn'>
						<el-button type="primary" @click="searchItem_cat()">Search</el-button>
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
				catalogs:[],
				cat_make:'',
			}
		},
		mounted(){
			
			this.$http.get('/api/makes').then(response => {
			    // get body data
			    this.makes = response.body;
			    
			  }, response => {
			  	// error 
			  });

			this.$http.get('/api/catalogs').then(response=>{
				this.catalogs = response.body.catalogs;
			}, response=>{
				// error log
			});
		},
		methods:{
			displayName(value){
				return value.replace(/&/," ").toUpperCase();
			},
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
			},

			searchItem_cat(){
				var name = this.cat_make;
				if (name!='') {
					window.localStorage.setItem('pdf_make',name);
					this.$router.push({name:'Booklet',params:{make:name}});
				}else{
					
				}	
				
				this.$emit('closeSearchLayer',false);
			},
		},
	}
</script>

<style scoped>
	@media screen and (min-width:1300px){
		.searchBar{
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
		}
		.cat1{
			padding-right: 30px;
			width: 450px;
			
		}

		.cat2{
			padding-left: 10px;
			width: 450px;
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

		.searchBtn{
			
		}
	}
	
	@media screen and (max-width: 1300px){
		.searchBar{
			display: flex;
			flex-direction: column;
			justify-content: center;
			
			
		}
		.cat1{
			padding-bottom: 30px;
		}

		.cat2{
			padding-top: 10px;
		}
		.searchCatalog{
			display: flex;
			
			flex-direction: column;
			border-top: 1px solid black;
		}

		.searchDetails{
			display: flex;
			flex-direction: column;
		}

		.searchBtn{
		}
	}
	
	.searchTitle{
		font-weight: bold;
		text-align: center;
		font-size: 20px;
		padding-bottom: 20px;
		width: 100%;
	}

	.searchTitle_D{
		padding-left: 15px;
		text-align: left;
		font-size: 16px;
		padding-bottom: 20px;
		width: 100%;
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
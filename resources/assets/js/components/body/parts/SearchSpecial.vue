<template>
	<div class="searchBar">
		<!-- home page search bar -->
       <form class='searchForm mobile_no' >
			<div class='words'>
				FIND IN SPECIALS:
			</div>

			<div class="inputSearch">
			
				<el-input v-model="search.item" placeholder="Enter a specific item number, ie. 1000A, 1860, M1035B, etc.">

								</el-input>
				<div class='mySelect'>
				<el-select v-model="search.make" placeholder="Make" style='width:120px;'>
					<el-option
						v-for="item in makes"
						:key="item.id"
						:label="item.make.replace('_',' ').toUpperCase()"
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
				<button class='btn btn-primary findBTN' @click="searchItem()">FIND</button>
				<a class='btn btn-warning findBTN' @click="resetSearch()">Reset</a>
			</div>
                  
		</form>


		<form class='searchForm mobile_show'>
			<div class='words'>
				FIND IN SPECIALS:
			</div>
			<div class="inputSearch mobile_show">
				<el-input v-model="search.item" placeholder="Enter a specific item number, ie. 1000A, 1860, M1035B, etc.">

								</el-input>
				<div class='mySelect'>
				<el-select v-model="search.make" placeholder="Make" >
					<el-option
						v-for="item in makes"
						:key="item.id"
						:label="item.make.replace('_',' ').toUpperCase()"
						:value="item.make">
					</el-option>
				</el-select >
				</div>
				<div class='mySelect'>	
				<el-select v-model="search.year" placeholder="Year" >
					<el-option
						v-for="a in (currentYear)"
						:key="a"
						:label="a"
						:value="a"			
						v-if="a>1949">
									</el-option>
												</el-select >
				</div>
			</div>
			
			
			<div style='display:flex; justify-content:space-around'>
				<a class='btn btn-warning findBTN col-xs-4' @click="resetSearch()">Reset</a>	

				<button class='btn btn-primary findBTN col-xs-4' @click="searchItem()">FIND</button>
			</div>
			
		</form>
	</div>
</template>

<script>
	export default{
		props:['search'],
		data(){
			return {
				makes:{},
				sr:{},
				currentYear:new Date().getFullYear(),
				page:1,
			}
		},
		mounted(){
			if (this.make) {
				this.search.make = this.make;
			}
			this.$http.get('/api/makes').then(response => {
			    this.makes = response.body;
			    
			  }, response => {
			  });
		},

		methods:{
			searchItem(){
				this.$emit("updateSearch",this.search);
				// this.$http.post('/api/searchSpecial',{
				// 	item:this.search.item, 
				// 	make:this.search.make,
				// 	year:this.search.year,
				// 	desc:this.search.desc,
				// 	page:this.page,
				// }).then(response=>{
				// 	console.log(response.data);
				// });
			},

			resetSearch(){
				this.$emit('resetSearch');
			}

		}	

		
	}
</script>

<style scoped>
	.mobile_show{
		display: none ;
	}
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

@media screen and (min-width:1000px){
	.words{
    	width: 20%;
    	font-weight: bold;
    	line-height: 40px;
    	align-items: center;
    	font-size: 1.2em;

    }
	.mobile_show{
		display: none ;
	}
}
@media screen and (max-width:1000px){
	.words{
    	width: 20%;
    	font-weight: bold;
    	line-height: 40px;
    	align-items: center;
    	font-size: 14px;
    }

	.mobile_show{
		display: none ;
	}
}

@media screen and (max-width: 768px){
	.mobile_no{
		display: none !important;
	}
	.mobile_show{
		display: block;
	}
	.searchForm{
      width: 80%;
      margin: auto;
      display: flex;
	  flex-direction: column;
      color: white;
    }
	.inputSearch{
		display: flex;
		flex-direction: column;
    	justify-content: space-between;
	}
	
	.words{
    	width: 100%;
    	font-weight: bold;
    	line-height: 40px;
    	text-align: left;
    	font-size: 1.2em;
    }

	.mySelect{
    	margin-left: 0;
		margin-top: 30px;
    }

	.findBTN{
      margin-left: 0px;
      height: 40px;
      padding-left: 20px;
      padding-right: 20px;
      line-height: 30px;
	  margin-top: 30px;
    }

	.searchForm{
      width: 95%;
      margin: auto;
      display: flex;
      justify-content: space-around;
      color: white;
    }
}
</style>
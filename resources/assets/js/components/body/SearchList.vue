<template>
	<div class='container' v-loading='loading'  
		element-loading-text="Searching ..." style='min-height:600px;'>
		<table class="table table-striped table-bordered vertical-center mobile_no" v-if='result' style='margin-top:30px; '>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
					<th style='min-width:120px;'>Thumbnail</th>
                    <th>Compatible Make</th>
                    <th class='text-right' style='min-width:120px;'>Price</th>
                    <th class='text-center'>Action</th>
                </tr>
            </thead>
            <tbody>
				
                <tr v-for="thing in list" :key="thing.item">
                    <td class='linkHover' style='height:80px; vertical-align:middle !important;cursor:pointer' @click="goToItem(thing.item)">{{thing.item}}</td>
                    <td class='linkHover' style='cursor:pointer' @click="goToItem(thing.item)">{{thing.descrip}}</td>
					<td :style="{ backgroundImage: 'url(' + thing.img_path + ')' }"
						style='
							padding:5px;
							height:80px; 
							background-size:contain;
							background-repeat:no-repeat;
							background-position:center'
					></td>
                    <td>
						<span v-for="item_make in makes" :key="item_make.row_id" v-if="item_make.item == thing.item" style='cursor:pointer;margin-right:15px;
						' 
						 @click="goToMake(item_make.make)" class='linkHover'> 
							{{item_make.make}} 
						</span>
					</td>
                    <td class='text-right' v-if="thing.onhand-thing.aloc > thing.orderpt && discount">CAD ${{(thing.pricel*0.9).toFixed(2)}}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ (((thing.pricel)/$store.state.exchange)*0.9).toFixed(2) }}</span></td>

					<td class='text-right' v-if="thing.onhand-thing.aloc <= thing.orderpt || !discount">CAD ${{thing.pricel.toFixed(2)}}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ ((thing.pricel)/$store.state.exchange).toFixed(2) }}</span></td>

                    <td class='text-center'>
                        <button class="btn btn-primary" @click="goToItem(thing.item)">Item Details</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="container paginate_btn  mobile_no" v-if='result'>

			<div class='col-xs-4 text-right'>
				<!-- pre page -->
				<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
					Previous Page
				</button>
			</div>

			<div class='col-xs-4 text-center'>
				{{data.total}}  Products found, Page 
				<el-select v-model="page" placeholder="Change Page" style='width:80px;' @change='toPage(page)'>
					<el-option
						v-for="p in data.last_page"
						:key="p"
						:label="p"
						:value="p">
					</el-option>
				</el-select> / of {{data.last_page}}
			</div>

			<div class='col-xs-4'>
				<!-- next page -->
				<button class="btn btn default" @click="nextPage()" v-if="data.current_page!=data.last_page">
					Next Page
				</button>
			</div>
				
				
		</div>


		<!-- mobile shows -->
		<div class="mobile_show">
			<div class='container mobile_list' v-for="thing in list" :key="thing.item" @click="goToItem(thing.item)">
				<div class="col-xs-4" :style="{ backgroundImage: 'url(' + thing.img_path + ')' }"
						style='
							padding:5px;
							height:150px; 
							background-size:contain;
							background-repeat:no-repeat;
							background-position:center'>
				</div>
				<div class="col-xs-8 mobile_words">
					<div style='display:flex;flex-direction:column'>
						<span class='linkHover' style='cursor:pointer'><b>{{showLimitedWords(thing.descrip,35)}}</b></span>
						<span>
							<span v-for="item_make in makes" :key="item_make.row_id" v-if="item_make.item == thing.item" style='cursor:pointer;margin-right:15px;
							' 
							class='linkHover'> 
								{{item_make.make}} 
							</span>
						</span>
					</div>
					
					<div>
                    	<span class='text-right cadPrice ' v-if="thing.onhand-thing.aloc > thing.orderpt && discount">CAD ${{(thing.pricel*0.9).toFixed(2)}}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ (((thing.pricel)/$store.state.exchange)*0.9).toFixed(2) }}</span></span>

						<span class='text-right cadPrice' v-if="thing.onhand-thing.aloc <= thing.orderpt || !discount">CAD ${{thing.pricel.toFixed(2)}}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ ((thing.pricel)/$store.state.exchange).toFixed(2) }}</span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="container paginate_btn  mobile_show mobile_btn" v-if='result'>

			<div class='col-xs-3'>
				<!-- pre page -->
				<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
					Previous
				</button>
			</div>

			<div class='col-xs-3 text-center'>
				
				<el-select v-model="page" placeholder="Change Page" style='width:80px;' @change='toPage(page)'>
					<el-option
						v-for="p in data.last_page"
						:key="p"
						:label="p"
						:value="p">
					</el-option>
				</el-select>
			</div>

			<div class='col-xs-3'>
				<!-- next page -->
				<button class="btn btn default" @click="nextPage()" v-if="data.current_page!=data.last_page">
					Next Page
				</button>
			</div>
				
				
		</div>

		<div v-if='empty' class='alert alert-warning' style='margin-top:30px;'>

			<b>Your search did not match any products.<br></b>
			Try something like<br>
			<ul>
			<li>Using more general terms</li>
			<li>Checking your spelling</li>
			</ul>
		</div>
	</div>
		
</template>
<script>

	export default {
		data(){
			return {
                item:this.$route.query.item,
                make: this.$route.query.make,
                year:this.$route.query.year,
                desc:this.$route.query.desc,
				list:[],
				data:[],
				page:this.$route.query.page,
				result:false,
				empty:false,
				loading:1,
				
				discount:true,
			}
		},

		mounted(){
			
            this.$http.get('/api/searchResualt', 
					{params:
						{
							item:this.item, 
							make:this.make,
							year:this.year,
							desc:this.desc,
							page:this.page,
						}
					}).then(response => {
				// get body data
				this.list = response.body.items.data;
				this.list.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});

				this.data = response.body.items;
				this.page = this.data.current_page;
				this.makes = response.body.item_makes;
				if (this.data.total>=1) {
					this.result=true;
					// i need put the search details to vuex, in order to backbing to search result pages
					this.$store.commit('setItem',this.item);
					this.$store.commit('setMake',this.make);
					this.$store.commit('setDesc',this.desc);
					this.$store.commit('setYear',this.year);
					this.loading=0;
				}else{
					this.empty=true;
					this.loading=0;
				}
			  }, response => {
			     
			  });


			  if (this.ifDealer()) {
				  this.discount = false;
			  }else{
				  this.discount = true;
			  }

			  
        },

		

        methods:{
            goToItem(id){
                this.$router.push({ name: 'ItemDetails', params: { id:id }})
			},

			goToMake(make){
				this.$router.push({ name: 'Pruduct_list', query: { make:make }});
			},
			
            nextPage(){
				this.page +=1;
				this.$router.push({name:'SearchList',query:{
							item:this.item, 
							make:this.make,
							year:this.year,
							desc:this.desc,
							page:this.page,
						}});

				},
			prePage(){
				this.page -=1;
				this.$router.push({name:'SearchList',query:{
							item:this.item, 
							make:this.make,
							year:this.year,
							desc:this.desc,
							page:this.page,
						}});
			},

			toPage(page){
				this.page =page;
				
				this.$router.push({name:'SearchList',query:{
							item:this.item, 
							make:this.make,
							year:this.year,
							desc:this.desc,
							page:this.page,
						}});
			},
			showLimitedWords:function(str,num){
				
				if (str.length <= num) {
					return str;
				}else{
					str = str.slice(0,num)+'...';
					return str;
				}
				
			},

			  
        },
		watch: {
			
		},
		computed:{
			getItem(){
				return this.$store.state.search.item;
				
			},
			getMake(){
				return this.$store.state.search.make;
			},
			getDesc(){
				return this.$store.state.search.desc;
			},
			getYear(){
				return this.$store.state.search.year;
			},

			usdPrice(){
				return this.$store.state.usdPrice;
			},

			
		}
	}
</script>
<style scoped>
    .paginate_btn{
		margin-top: 20px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20px;
	}
	.paginate_btn .btn{
		min-width: 115px;
	}

	td{
		height:80px; 
		vertical-align:middle !important;
	}

	.linkHover:hover{
		text-decoration: underline;
	}

	.mobile_show{
		display: none;
	}
	@media screen and (max-width:768px) {
		.mobile_no{
			display: none !important;
		}
		.mobile_show{
			display: block;
		}
		.mobile_list{
			border-bottom: 1px solid black;
			margin-top: 10px;
			height: 160px;
		}
		.mobile_words{
			min-height: 150px;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			align-items: flex-start;
		}
		.cadPrice{
			color: red;
		}
		.mobile_btn{
			display: flex;
			justify-content: space-between;
		}
		.paginate_btn{
			margin-top: 20px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}
		.paginate_btn .btn{
			min-width: 80px;
		}
		
	}	
	
</style>
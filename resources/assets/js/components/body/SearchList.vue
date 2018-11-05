<template>
	<div class='container' v-loading='loading'  
		element-loading-text="Searching ..." style='min-height:600px;'>
		<table class="table table-striped table-bordered vertical-center" v-if='result' style='margin-top:30px; '>
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
                    <td  style='height:80px; vertical-align:middle !important'>{{thing.item}}</td>
                    <td>{{thing.descrip}}</td>
					<td :style="{ backgroundImage: 'url(' + thing.img_path + ')' }"
						style='
							padding:5px;
							height:80px; 
							background-size:contain;
							background-repeat:no-repeat;
							background-position:center'
					></td>
                    <td>
						<span v-for="item_make in makes" :key="item_make.row_id" v-if="item_make.item == thing.item"> 
							{{item_make.make}} &nbsp; 
						</span>
					</td>
                    <td class='text-right' v-if="thing.onhand > thing.orderpt && discount">CAD ${{(thing.pricel*0.9).toFixed(2)}}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ (((thing.pricel)/$store.state.exchange)*0.9).toFixed(2) }}</span></td>

					<td class='text-right' v-if="thing.onhand <= thing.orderpt || !discount">CAD ${{thing.pricel.toFixed(2)}}<br>
						<span v-if='usdPrice' class='usdPrice'>USD ${{ ((thing.pricel)/$store.state.exchange).toFixed(2) }}</span></td>

                    <td class='text-center'>
                        <button class="btn btn-primary" @click="goToItem(thing.item)">Item Details</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="container paginate_btn" v-if='result'>
				<div class="text-left">
					{{data.total}}   Products found, Page {{page}} of {{data.last_page}}
				</div>
				<div>
					<!-- pre page -->
					<button class="btn btn-default" @click='prePage()' 	v-if="data.current_page!=1">
						Previous Page
					</button>
					<!-- next page -->
					<button class="btn btn-default" @click="nextPage()" v-if="data.current_page!=data.last_page">
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
                make:this.$route.query.make,
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
				console.log(response);
				this.list.forEach(element => {
					element.pricel = this.Dealerprice(element);
				});

				this.data = response.body.items;
				this.page = this.data.current_page;
				this.makes = response.body.item_makes;
				console.log(this.makes);
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
			    console.log("error");
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
				console.log(this.page);
				this.$router.push({name:'SearchList',query:{
							item:this.item, 
							make:this.make,
							year:this.year,
							desc:this.desc,
							page:this.page,
						}});
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
	
</style>
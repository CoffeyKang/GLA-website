<template>
    <div class="container-fuild container"  v-loading="loading">
        <div class="images_change">
            <el-carousel indicator-position="inside" height='400px'>

                <el-carousel-item v-for="banner in banners" :key='banner.id'  >
                  <router-link :to="banner.link" tag='div' class="banner" :style="{ backgroundImage: 'url(' + banner.img_path + ')' }">
                  </router-link>
                  
                </el-carousel-item>
            </el-carousel>
        </div>

        <app-search></app-search>

        

        <div class="ads row" >
        <div v-for="ad in ads " class='col-xs-4' :key="ad.id">
          <div class="ad " :style="{ backgroundImage: 'url(' + ad.img_path + ')' }">
            
          </div>
        </div>
           

        </div>

        <div class="sub_title">
          <span>FEATURE PRODUCTS</span>
        </div>
          <div class='container-fluid fitems'>
            <div v-for="a in featureProducts" :key="a.id">
                <app-item :item="a"></app-item>
            </div>
          </div>  

        <div class="popular">
          <div class="sub_title">
            <span>MOST POPULAR ITEMS</span>
          </div>

          <div class='feature_item container-fluid popular'>
            <div v-for="a in popular" :key='a.id' >
                <app-item :item="a"></app-item>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
  import Item from '../Item.vue';
  import SearchBar from './parts/SearchBar.vue';

    export default {
      data(){
        return {
          banners : {},
          featureProducts:{},
          ads:{},
          popular:{},
          loading:1,

        }
      },
        components:{
          appItem:Item,
          appSearch:SearchBar
        },
        mounted(){
          // get banner
          this.$http.get('/api/banner').then(response=>{
            this.banners = response.body;
          }, response=>{
            // error log
          });

          // get ads
          this.$http.get('/api/ads').then(response=>{
            this.ads = response.body;
            
          }, response=>{
            // error log
          });


          // get featureProducts
          this.$http.get('/api/featureProducts').then(response=>{
            this.featureProducts = response.body;
          }, response=>{
            // error log
          });

         //get most populars
          this.$http.get('/api/popular').then(response=>{
            this.popular = response.body;
            this.loading = 0;
          }, response=>{
            // error log
          });
        },
        methods:{
          
        }
    }
</script>

<style scoped>
   .banner{
      height: 400px;
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      cursor:pointer;
    }
    
    
    
    .searchBar{
          background-color: black;
          padding-top: 20px;  
          padding-bottom: 20px;

        }

    
    
        
        

        .ads{
          margin-top: 20px;
          margin-bottom: 20px;
          display: flex;
          flex-direction: row;
          justify-content: space-between;


          
          
        }

        .ad{
          background-position: 50%;
          background-repeat: no-repeat;
          background-size: cover;
          height: 400px;
          cursor:pointer;
        }
        .sub_title{
          margin-top: 20px;
          margin-bottom: 20px;
          padding: 10px 30px;
          color: black;
          background-color: yellow;
          font-size: 1.5em;
          font-weight: bold;
        }
        
        .feature_item{
          display: flex;
          justify-content: space-between;
          flex-wrap: wrap;
        }

        .fitems{
          display: flex;
          justify-content: space-between;
          flex-wrap: nowrap;
          overflow: scroll;
          overflow-y:hidden;
          
          
        }

        .popular{
          margin-bottom: 50px;
        }

        /* width */
      ::-webkit-scrollbar {
          width: 10px;
      }

      /* Track */
      ::-webkit-scrollbar-track {
          background: #f1f1f1; 
      }
      
      /* Handle */
      ::-webkit-scrollbar-thumb {
          background: #888; 
      }

      /* Handle on hover */
      ::-webkit-scrollbar-thumb:hover {
          background: #555; 
      }
        
    
      

</style>

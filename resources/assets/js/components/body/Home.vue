<template>
    <div class="container-fuild container"  v-loading="loading">
        <div class="images_change mobile_no">
            <el-carousel indicator-position="inside" height='400px' arrow="always">
                <el-carousel-item v-for="banner in banners" :key='banner.id'  >
                  <router-link :to="banner.link" tag='div' class="banner" :style="{ backgroundImage: 'url(' + banner.img_path + ')' }">
                  </router-link>
                </el-carousel-item>
            </el-carousel>
        </div>

        <div class="container mobile_banner mobile_show">
            
        </div>

        
        <app-search></app-search>
        <div class="ads ">
        <div v-for="ad in ads " class=' col-xs-12 col-sm-4' :key="ad.id" >
          <div class="ad " :style="{ backgroundImage: 'url(' + ad.img_path + ')' }" @click="goto(ad.id)">
          </div>
        </div>
        </div>
        <div class="sub_title">
          <span>FEATURE PRODUCTS</span>
        </div>
        <div class="container-fluid arrow" >
            <div class='left' @click='left()'>
            </div>
            <div class='container-fluid fitems' id='fitems' @mouseover="FeatureSpeed=0" @mouseout="FeatureSpeed=1">
              <div v-for="a in featureProducts" :key="a.id">
                  <app-item :item="a"></app-item>
              </div>
            </div> 
            <div class='right' @click='right()'>
                
            </div> 
        </div>

        <!-- popular  -->
        <div class="popular">
          <div class="sub_title">
            <span>MOST POPULAR ITEMS</span>
          </div>

          <div class="container-fluid arrow" >

        
            <div class='pleft' @click='pleft()'>
                
            </div>

            <div class='container-fluid pitems' id='pitems' @mouseover="PopularSpeed=0" @mouseout="PopularSpeed=1">
              <div v-for="a in popular" :key="a.id">
                  <app-item :item="a"></app-item>
              </div>
            </div> 
            <div class='pright' @click='pright()'>
                
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
          FeatureSpeed:1,
          PopularSpeed:1,
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
             this.loading = 0;
          }, response=>{
            // error log
          });

         //get most populars
          this.$http.get('/api/popular').then(response=>{
            this.popular = response.body;
          
          }, response=>{
            // error log
          });

          // this.$nextTick(function () {
          //   window.setInterval(() => {
          //       document.getElementById('fitems').scrollLeft += this.FeatureSpeed;
          //       document.getElementById('pitems').scrollLeft += this.PopularSpeed;
          //   },50);
          // });
          
            

        },
        methods:{
          right(){
              document.getElementById('fitems').scrollLeft += 250;
          },

          left(){
              document.getElementById('fitems').scrollLeft -= 250;
          },
          pright(){
              document.getElementById('pitems').scrollLeft += 250;
          },

          pleft(){
            
              document.getElementById('pitems').scrollLeft -= 250;
              
            
          },

          goto(id){
            if (id==1) {
              this.$router.push('/newItems');
            }else if(id==2){
              this.$router.push('/special');
            }else{
              this.$router.push('/catalog');
            }
          }


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
          background-color: #FFE512;
          font-size: 1.5em;
          font-weight: bold;
        }
        
        .feature_item{
          display: flex;
          justify-content: space-between;
          flex-wrap: wrap;
        }

        .fitems, .pitems{
          display: flex;
          justify-content: space-between;
          flex-wrap: nowrap;
          overflow: scroll;
          overflow-y:hidden;
          overflow-x:hidden;
          position: relative;
          
          
        }

        .popular{
          margin-bottom: 30px;
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
      
      .arrow{
        display: flex;
        flex-direction: row;
      }

      .left, .right{
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        min-width: 50px;
      }

      .pleft, .pright{
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        min-width: 50px
      }
      .left, .pleft{
        background-image: url("/images/left.png");
        cursor: pointer;
      }
      .right, .pright{
        background-image: url("/images/right.png");
        cursor: pointer;
      }

      .el-icon-arrow-right, .el-carousel__arrow{
        color: red !important;
        background-color: red !important;
      }


      
      
      .el-carousel__arrow, .el-carousel__arrow--left{
        background-image: url('/images/left.png') !important;
        background-size: contain !important;
        height: 50px !important;
        width: 50px !important;
        background-position: center !important;
      }

      .mobile_show{
        display: none;
      }
 

      @media screen and (max-width: 768px) {
        .mobile_no{
          display: none;
        }

        .mobile_banner{
          height: 400px;
          background-image: url('/images/default_sm.jpg');
          background-position: center;
          background-size: contain;
          background-repeat: no-repeat;
        }
        .mobile_show{
          display: block;
        }

        .GLA_banner{
          background-color: #FFE512;
          
        }

        .banner{
          height: 400px;
          background-repeat: no-repeat;
          background-size: cover;
          background-position: center;
          cursor:pointer;
        }

        .ads{
          margin-top: 20px;
          margin-bottom: 20px;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
        }

        .left, .right{
          background-size: contain;
          background-position: center;
          background-repeat: no-repeat;
          min-width: 20px;
        }

        .pleft, .pright{
          background-size: contain;
          background-position: center;
          background-repeat: no-repeat;
          min-width: 20px
        }

        .sub_title{
          margin-top: 20px;
          margin-bottom: 20px;
          padding: 10px 30px;
          color: black;
          background-color: #FFE512;
          font-size: 1.5em;
          font-weight: bold;
          text-align:center;
        }
      }
      

</style>

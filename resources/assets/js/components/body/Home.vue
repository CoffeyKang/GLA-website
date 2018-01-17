<template>
    <div class="container-fuild">
        <div class="images_change">
            <el-carousel indicator-position="inside" height='400px'>

                <el-carousel-item v-for="banner in banners" :key='banner.id'  >
                  <router-link :to="banner.link" tag='div' class="banner" :style="{ backgroundImage: 'url(' + banner.img_path + ')' }">
                    
                  </router-link>
                  
                </el-carousel-item>
            </el-carousel>
        </div>

        <div class="searchBar">
                <form class="form-inline">
                  <div class="form-group">
                    <label class='form-label'>I NEED TO FIND: </label>
                    <input type="text" class="form-control" placeholder="Enter a specific part, ie. Fender, Hood, Lamp, etc.">
                  </div>
                  <div class="form-group">
                    <label for="inputPassword2" class="sr-only">Make</label>
                    <input type="password" class="form-control" placeholder="Make">
                  </div>
                  <div class="form-group ">
                    <label for="inputPassword2" class="sr-only">Year</label>
                    <input type="password" class="form-control" placeholder="Year">
                  </div>
                  <button type="submit" class="btn btn-primary"> FIND </button>
                </form>
        </div>

        <div class="advertisements container" v-for="ad in ads">
        
          <div class="ad" :style="{ backgroundImage: 'url(' + ad.img_path + ')' }">
            
          </div>
           

        </div>

          <div class="sub_title container">
            <span>FEATURE PRODUCTS</span>
          </div>
          <div class='feature_item container'>
            <div v-for="a in featureProducts" >
                <app-item :item="a"></app-item>
            </div>
          </div>  

        <div class="popular">
          <div class="sub_title">
            <span>MOST POPULAR ITEMS</span>
          </div>

          <div class='feature_item'>
            <div v-for="a in featureProducts">
                {{ a.item }}
            </div>
            
          </div>
        </div>




        
    </div>
</template>

<script>
  import Item from '../Item.vue';

    export default {
      data(){
        return {
          banners : {},
          featureProducts:{},
          ads:{},

        }
      },
        components:{
          appItem:Item
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
            console.log(this.ads);
          }, response=>{
            // error log
          });


          // get featureProducts
          this.$http.get('/api/featureProducts').then(response=>{
            this.featureProducts = response.body;
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
    
    
    @media screen and (min-width: 1140px) {
        .images_change, .searchBar, .advertisements, .feature , .popular{
            width:1140px;
            margin: auto;
        }

        
    }
    .searchBar{
            background-color: black;
            display: flex;
            justify-content: center;
            padding:20px;
            margin-top: 20px;
        }
        
        form div{
            margin-left: 30px;
        }

        form label{
            font-size: 1.5em;
            color: white;
        }
        form button{
          margin-left: 30px;
          font-size: 1.5em;
          padding: 0 20px;
        }

        .advertisements{
          margin-top: 20px;
          display: flex;
          
        }

        .ad{

          height: 400px;
          background-position: center;
          background-size: 100%;
          background-repeat: no-repeat;
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
        
    
      

</style>

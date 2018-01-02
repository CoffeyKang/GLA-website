<template>
    <div class="container-fuild">
        <div class="images_change">
            <el-carousel indicator-position="inside">
                <el-carousel-item v-for="item in 5" :key="item">
                  <h3>{{ item }}</h3>
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

        <div class="advertisements">
        
          <div class="ad">
            ad1
          </div>
          <div class="ad">
            ad2
          </div>
          <div class="ad">
            ad3
          </div>          

        </div>

        <div class="feature">
          <div class="sub_title">
            <span>FEATURE PRODUCTS</span>
          </div>
          <div class='feature_item'>
            <div class='first_item'>
              <app-item></app-item>
            </div>
            <div>
              <app-item></app-item>
            </div>
            <div>
              <app-item></app-item>
            </div>
            <div class='right_item'>
              <app-item></app-item>
            </div>
          </div>
        </div>

        <div class="popular">
          <div class="sub_title">
            <span>MOST POPULAR ITEMS</span>
          </div>

          <div class='feature_item'>
            <div class='first_item'>
              <app-item></app-item>
            </div>
            <div>
              <app-item></app-item>
            </div>
            <div>
              <app-item></app-item>
            </div>
            <div class='right_item'>
              <app-item></app-item>
            </div>
          </div>
        </div>




        
    </div>
</template>

<script>
  import Item from '../Item.vue';

    export default {
        components:{
          appItem:Item
        }
    }
</script>

<style scoped>
    .el-carousel__item h3 {
      color: #475669;
      font-size: 18px;
      opacity: 0.75;
      line-height: 300px;
      margin: 0;
    }
      
    .el-carousel__item:nth-child(2n) {
      background-color: #99a9bf;
    }
      
    .el-carousel__item:nth-child(2n+1) {
      background-color: #d3dce6;
    }
    
    
    @media screen and (min-width: 1300px) {
        .images_change, .searchBar, .advertisements, .feature , .popular{
            width:1200px;
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
          justify-content: space-between;
        }

        .ad{
          width:32%;
          height: 350px;
          background-color: gray;
        }

        .feature, .popular{
          margin-top: 20px;
        }
        .first_item{
          padding-left: 0;
        }
        .last_item{
          padding-right: 0;
        }
        .feature_item{
          display: flex;
          
        }
        .feature_item div{
          width:100%;
        }

        .sub_title{
          padding: 10px 30px;
          color: black;
          background-color: yellow;
          font-size: 1.5em;
          font-weight: bold;
        }

        .popular{
          margin-bottom: 30px;
        }
    
      

</style>

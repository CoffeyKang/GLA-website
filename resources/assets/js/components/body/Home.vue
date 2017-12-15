<template>
    <div class="container-fuild">
        <div class="images_change">
            <el-carousel indicator-position="inside">
                <el-carousel-item v-for="item in 5" :key="item">
                  <h3>{{ item }}</h3>
                </el-carousel-item>
            </el-carousel>
            
            <div class="searchBar">
                <form class="form-inline">
                  <div class="form-group">
                    <label class='form-label'>I NEED TO FIND: </label>
                    <input type="text" class="form-control" placeholder="Enter a specific part, ie. Fender, Hood, Lamp, etc.">
                  </div>
                  <div class="form-group mx-sm-3">
                    <label for="inputPassword2" class="sr-only">Make</label>
                    <input type="password" class="form-control" placeholder="Make">
                  </div>
                  <div class="form-group mx-sm-3">
                    <label for="inputPassword2" class="sr-only">Year</label>
                    <input type="password" class="form-control" placeholder="Year">
                  </div>
                  <button type="submit" class="btn btn-primary"> FIND </button>
                </form>
            </div>
           
                
                
        </div>

        
    </div>
</template>

<script>
    export default {
        
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
        .images_change, .searchBar{
            width:1300px;
            margin: auto;
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
    }
    
      

</style>

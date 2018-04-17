<template>
	<div class='container adminPage'>
		
        <div class="userNav" >
            <div class='myAvatar'>
               <span> {{userInfo.m_forename + ' ' + userInfo.m_surname}}</span>
                <span> {{ userInfo.m_title }} </span>
            </div>
            <div class="list-group container-fuild">
                <router-link :to="{name:'setPromotion'}" tag='a' class='list-group-item'>Set promotion discount</router-link>
                <router-link :to="{name:'editUser'}" tag='a' class='list-group-item'>Set promotion discount</router-link>
                <a href="#" class="list-group-item">Customer and dealer report</a>
                <a href="#" class="list-group-item">Add new customer and dealer</a>
                <a href="#" class="list-group-item">Edit dealer and customer</a>
                <a href="#" class="list-group-item">Show deal order history</a>
                <a href="#" class="list-group-item">Show customer history</a>
                <a href="#" class="list-group-item">Pending quote</a>
                <a href="#" class="list-group-item">Awaits report</a>
            </div>
        </div>
        <div class=" userContent">
            <router-view></router-view>  
        </div>
		
	</div>
</template>

<script>
	export default {
		data(){
			return {
                user:JSON.parse(localStorage.getItem('user')),
                userInfo:JSON.parse(localStorage.getItem('userInfo')),
			}
		},
		mounted(){
            console.log(this.userInfo);
            console.log(localStorage);
		},
		methods:{
			
		}
	}
</script>

<style scoped>
	.adminPage, .userNav, .userContent{
        min-height: 1500px;

    }
    .adminPage{
        display: flex;
    }
    .userNav{
        width: 30%;
    }
    .userContent{
        width: 70%;
    }
    .userNav{
        background-color: gray;
    }
    .myAvatar{
        display: flex;
        flex-direction: column;
        font-size: 14px;
        height: 100px;
        justify-content: center;
        align-items: center;

    }
    .list-group,.list-group-item{
        color: black;
        background-color: gray;
        border-color: gray;
    }
	
</style>
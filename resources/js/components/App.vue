<template>
    <div class="" style="min-height: 100%; height: 100%;">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            
            <div class="container p-0">
                <div class="navbar-nav">
                    <router-link class="nav-item nav-link" :to="{name:'home'}">На главную</router-link>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid vh-100">
            <router-view></router-view>
        </div>

    
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>

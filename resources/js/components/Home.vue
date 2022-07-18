<template>
    <div class="container d-flex flex-column justify-content-sm-between" style="min-height: 100%; height: 100%;">

        <div >

            <div class="row d-flex justify-content-md-between ">
                <h1>Объявления</h1>
                <router-link class="btn btn-success" style="padding: 10px;" :to="{name:'add'}">Подать объявление</router-link>
            </div>

            <div class="row">
                <div class="form-group col-md-2 p-0">
                    <select class="form-control" v-model="sort" @change="viewAds()">
                        <option v-for="s in sortList" :value="s.value" v-html="s.name" ></option>
                    </select>
                </div>
            </div>

            <div class="row ">
                <div class="d-flex justify-content-md-between w-100 flex-wrap">

                    

                        <div class="card mb-3" style="width: 16rem;" v-for="ad in ads">
                            <img class="card-img-top" :src="ad.images[0].link" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ad.name}}</h5>
                                <p class="card-text"><small class="text-muted">{{ad.price}}</small></p>
                            </div>
                            <router-link class="btn btn-primary" :to="{name: 'show_add', params:{id: ad.id}}">
                                открыть
                            </router-link>
                        </div>
                </div>
            </div>
        </div>
        

        <div class="row  d-flex justify-content-center mt-3">
            <div class="col-md-8">
                <nav>
                    <ul class="pagination d-flex justify-content-center">
                        <li class="page-item"><a href="#" class="page-link" :class="{'disabled': !pagination.first_link}" @click="viewAds(pagination.first_link)">&laquo;</a></li>
                        <li class="page-item"><a href="#" class="page-link" :class="{'disabled': !pagination.prev_link}" @click="viewAds(pagination.prev_link)">&lt;</a></li>
                        <li class="page-item" v-for="n in pagination.last_page" :key="n"><a href="#" class="page-link" :class="{'active': !pagination.current_page == n}" @click="viewAds(pagination.path_page + n)">{{n}}</a></li>
                        <li class="page-item"><a href="#" class="page-link" :class="{'disabled': !pagination.next_link}" @click="viewAds(pagination.next_link)">&gt;</a></li>
                        <li class="page-item"><a href="#" class="page-link" :class="{'disabled': !pagination.last_link}" @click="viewAds(pagination.last_link)">&raquo;</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="alert alert-danger" role="alert" v-if="error == true">
            This is a danger alert—check it out!
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                ads:[],
                errors: [],
                error: false,
                pagination: {},
                sortList: [
                    {name: 'цена &#94;', value: 'priceUp'},
                    {name: 'цена &#709;', value: 'priceDown'},
                    {name: 'дата создания &#94;', value: 'dateUp'},
                    {name: 'дата создания &#709;', value: 'dateDown'}
                ],
                sort: 'priceUp'
            }
        },
        mounted() {
            this.viewAds()
        },

        methods:{
            viewAds(url){
                

                axios.get('/api/ad?sort=' + this.sort)
                    .then(response => {
                        this.ads = response.data.data;
                        this.pagination = {
                            current_page: response.data.meta.current_page,
                            last_page: response.data.meta.last_page,
                            from_page: response.data.meta.from,
                            to_page: response.data.meta.to,
                            total_page: response.data.meta.total,
                            path_page: response.data.meta.path + '?page=',
                            first_link: response.data.links.first,
                            last_link: response.data.links.last,
                            next_link: response.data.links.next,
                            prev_link: response.data.links.prev
                        }
                        console.log(this.ads);
                        
                    })
                    .catch(error => {
                        console.log(error);
                        this.error = true;
                    })
            }
        }
    }
</script>

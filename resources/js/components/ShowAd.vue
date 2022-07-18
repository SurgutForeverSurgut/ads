<template>
    <div class="container p-0" >

        <div class="card d-flex justify-content-md-center flex-column p-5"  >
            <div id="images" class="row d-flex justify-content-md-center">
                <div id="main_image" class="col-md-7 w-100">
                    <img class="card-img-top" :src="images[0].link" alt="">
                </div>
                <div id="other_images" class="col-md-3">
                    <img class="card-img-top" :src="img.link" v-for="img in images" alt="">
                </div>
            </div>
            
            <div class="card-body">
                <h5 class="card-title">{{name}}</h5>
                <p class="card-text">{{description ? description : ''}}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">цена: {{price}} руб.</li>
            </ul>
            
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'id',
        ],

        data(){
            return {
                name: null,
                description: null,
                price: null,
                images: []
            }
        },

        mounted() {
            axios.get('/api/ad/' + this.id + '?fields=1')
                .then(response => {
                    var ad = response.data.data;
                    this.name = ad.name;
                    this.description = ad.description;
                    this.price = ad.price;
                    this.images = ad.images;
                    console.log(this.images);
                    
                })
                .catch(error => {
                    console.log(error);
                    this.error = true;
                })    
        }
    }
</script>

<template>
    <div class="container p-0">
        <h1>Добавить объявление</h1>

        <form @submit.prevent="add">
        <div class="form-group">
            <label for="name">Заголовок объявления</label>
            <input type="text" v-model="name" class="form-control " :class="{ 'is-invalid': $v.name.$error }"  placeholder="заголовок">
            <div class="invalid-feedback" v-if="!$v.name.required">Обязательное поле</div>
            <div class="invalid-feedback" v-if="!$v.name.maxLength">Макс длина поля</div> 
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" :class="{ 'is-invalid': $v.description.$error }" v-model="description" rows="3"></textarea>
            <div class="invalid-feedback" v-if="!$v.description.required">Обязательное поле</div>
            <div class="invalid-feedback" v-if="!$v.description.maxLength">Макс длина поля</div>
        </div>
        
        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" class="form-control" :class="{ 'is-invalid': $v.price.$error }" v-model="price" placeholder="цена">
            <div class="invalid-feedback" v-if="!$v.price.required">Обязательное поле</div>
        </div>

        <div class="form-group img_link" >
            <label for="image-1">Ссылка на картинку</label>
            <input type="text" class="form-control img" :class="{ 'is-invalid': $v.image.$error }" v-model="image" placeholder="ссылка">
            <div class="invalid-feedback" v-if="!$v.image.required">Обязательное поле</div>
        </div>
        <div class="mb-3">
            <div class="form-group img_link" v-for="index in countImg" :key="index">
                <label for="image-1">Ссылка на картинку</label>
                <input type="text" class="form-control img" :class="{ 'is-invalid': $v.image.$error }" placeholder="ссылка">
            </div>
        
            <input type="button" class="btn btn-primary" @click="addImage" value="Добавить ссылку"/>
        </div>

        <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
</template>

<script type="application/javascript">
    import { required, maxLength } from 'vuelidate/lib/validators';

    export default {
        data(){
            return {
                name: null,
                description: null,
                price: null,
                images: [],
                image: null,
                countImg: 0
            }
        },

        methods:{
            addImage(){
                if(this.countImg > 1){
                    return;
                }
                this.countImg++;
            },

            add(){
                this.$v.$touch();
                var check = this.$v.$anyError;
                
                if(check){
                    return;
                }
                console.log(check);

                var link = document.querySelectorAll('.img');
                
                link.forEach(element => {
                    this.images.push(element.value);
                });

                axios.post('/api/ad/', {
                    _method: "POST",

                    name: this.name,
                    description: this.description,
                    price: this.price,
                    images: this.images
                })
                .then(response => {
                    if(!check){
                        this.$router.push({ name: 'home' });
                    }
                })
                .catch(error => {
                    console.log(error);
                }) 
            }
        },

        validations: {
            name: {
                required,
                maxLength: maxLength(200)
            },
            description: {
                required,
                maxLength: maxLength(1000)
            },
            price: {
                required
            },
            image: {
                required
            },
            
            
    }

    }
</script>

<template>
    <div class="images-list-container">
        <label class="custom-control custom-checkbox" v-for="img in images">
            <input type="radio" name="select-image" class="custom-control-input" :value="img.id" v-model="localSelectedImgID" :checked="selectedImageId===img.id" v-if="type==='single'">
            <input type="checkbox" name="select-image" class="custom-control-input" :value="img.id" v-model="localSelectedImgID" :checked="selectedImageId===img.id" v-else>
            <!--<span class="custom-control-indicator"></span>-->
            <span class="custom-control-description">
                <img :src="img.url" :alt="img.original_name" class="">
            </span>
        </label>
        <button type="button" class="btn btn-block btn-primary" @click="triggerNewImgInput">+ Add New Image</button>
        <input type="file" @change="uploadImage" class="new-img-input hidden">
    </div>
</template>
<script>
    export default {
        mounted() {
//            console.log('Image List ready.');
        },
        props: ['selectedImageId', 'type'],
        created() {
            // fetch the data when the view is created and the data is
            // already being observed
            this.fetchImages();
        },
        data() {
            return {
                loading: false,
                error: null,
                localSelectedImgID: this.selectedImageId, // shit, this thing is used to compute parent model value
                images: [],
            };
        },
        methods: {
            fetchImages() {
                // get all images
                axios.get(this.$root.$data.api.getAllImages)
                    .then((res) => {
                        // success
                        this.images = res.data.files;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        swal('error', 'Oh snap!', error);
                    });
            },

            triggerNewImgInput() {
                $('.new-img-input').trigger('click');
            },

            uploadImage(callback) {
                // get image data
                let data = new FormData();
                data.append('img', document.querySelector('.new-img-input').files[0]);
                axios.post(this.$root.$data.api.uploadNewImage, data)
                    .then((res) => {
                        // success
                        this.images.push(res.data.file);
                        switch (this.type) {
                            case 'single':
                                this.localSelectedImgID = res.data.file.id;
                                break;
                            default:
                                this.localSelectedImgID.push(res.data.file.id);
                                break;
                        }
                        if (typeof (callback) == 'function') {
                            callback();
                        }
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        swal('error', 'Oh snap!', error);
                    });
            },
        },
        watch: {
            'localSelectedImgID': function() {
                this.$emit('input', this.localSelectedImgID);
                console.log(['logoid: ', this.localSelectedImgID]);
            },

            selectedImageId: function(val, oldVal) {
                this.localSelectedImgID = val;
            }
        }
    }
</script>
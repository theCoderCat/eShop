<template>
    <div>
        <form action="" @submit="createTag">
            <div class="form-group">
                <input type="text" v-model="newTag" class="form-control" placeholder="Tag name">
                <button type="submit" class="btn btn-primary">Create tag</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <td>Name</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td v-for="tags as tag"><a href="{tag.url}">{tag.name}</a></td>
                </tr>
            </tbody>
        </table>

    </div>
</template>
<script>
    export default {
        mounted() {
            
        },
        created() {
            // fetch the data when the view is created and the data is
            // already being observed
            this.fetchTags();
        },
        components: {

        },
        data() {
            return {
                loading: false,
                error: null,
                api: {
                    'getAllTags': 'tags',
                    'createTag': 'tag/create'
                },
                tags: [],
                newTag: ""
            };
        },
        methods: {
            fetchTags() {
                //
                axios.get(this.api.getAllTags).then( (res) => {
                    // success
                    this.tags = res.data.tags;
                }).catch( (error) => {
                    //
                    console.log(error);
                    alert('cannot fetch tags');
                });
            },
            
            createTag() {
                axios.post(this.api.createTag, newTag).then( (res) => {
                    // success
                    this.tags.push(res.data.tag);
                }).catch( (error) => {
                    //
                    console.log(error);
                    alert('cannot fetch tags');
                });
            }
        }
    }
</script>
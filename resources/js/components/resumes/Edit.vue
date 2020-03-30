<template>
    <div class="resume-view" v-if="resume">
        <form @submit.prevent="updateForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
                </div>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text"  class="form-control" v-model="resume.name">
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input type="text" class="form-control" v-model="resume.desciption">
                    </td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td>
                        <input type="submit" value="Update" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'edit',
        created() {
            axios.get(`/api/resumes/${this.$route.params.id}`,{
                headers:{
                    "Authorization":`Bearer ${this.currentUser.token}`
                }
            })
                .then((response) => {
                    this.resume = response.data.resume
                });
            
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            resumes() {
                return this.$store.getters.resumes;
            }
        },
        data() {
            return {
                resume: {
                    name:'',
                    desciption:''
                },
                errors: []
            };
        },
        methods:{
        
            updateForm: function (e) {

                if (!this.resume.name) {
                    this.errors.push ("Name required")
                }
                if (!this.resume.desciption) {
                    this.errors.push("Description required")

                }

                if (!this.errors) {
                    axios.put(`/api/resumes/${this.$route.params.id}`, this.$data.resume,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.$store.commit('updateResumes',response.data.resumes);
                        this.$router.push('/resumes');
                    });
                }

                e.preventDefault();
            },
    
        }
    }
</script>
<style scoped>

    .table th{
        vertical-align:middle
    }

</style>
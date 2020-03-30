<template>
    <div class="resume-new">
        <form @submit.prevent="submitForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" class="form-control" v-model="resume.name" placeholder="Name"/>
                    </td>
                    <td>
                         <span v-if="errors.name">
                            {{ errors.name }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>
                        <input type="text" class="form-control" v-model="resume.description" placeholder="Description"/>
                    </td>
                    <td>
                         <span v-if="errors.description">
                            {{ errors.description }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/resumes" class="btn btn-danger">Cancel</router-link>
                    </td>
                    <td class="text-right">
                        <input type="submit" value="Create" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    export default {
        name:'new',
        computed:{
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        data() {
            return {
                resume: {
                    name:'',
                    description: '',
                },
                errors: [],
            };
        },
        methods:{
            submitForm: function (e) {

                this.errors = [];

                if (!this.resume.name) {
                    this.errors.push("Name required")
                }
                if (!this.resume.description) {
                    this.errors.push("Description required")
                }

                if (!this.errors) {
                    axios.post('/api/resumes/new', this.$data.resume,{
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
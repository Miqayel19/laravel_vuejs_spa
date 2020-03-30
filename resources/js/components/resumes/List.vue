<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/resumes/new" class="btn btn-primary">New</router-link>
        </div>
        <table class="table">
            <template>
                <thead>
                    <th>Name</th>
                    <th>Description</th>
                    <th colspan="3">Actions</th>
                </thead>
            </template>
            <tbody>
                <template v-if="!resumes.length">
                    <tr>
                        <td colspan="4" class="text-center">No Resumes Available</td>
                    </tr>
                </template>
                <template v-else>
                    <tr v-for="resume in resumes" :key="resume.id">
                        <td>{{ resume.name }}</td>
                        <td>{{ resume.desciption }}</td>
                        <td>
                            <router-link :to="`/resumes/${resume.id}`">Show</router-link>
                        </td>
                        <td>
                            <router-link :to="`/resumes/${resume.id}/edit`">Edit</router-link>
                        </td>
                        <td>
                             <input type="submit" value="Delete"  @submit.prevent="deleteResume(resume.id)" class="btn btn-danger"/> 
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'list',
        mounted() {
            if (this.resumes.length) {
                return;
            }
        
            this.$store.dispatch('getResumes');

        },
        computed:{
            resumes(){
                return this.$store.getters.resumes
            },
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            deleteResume(id){
                axios.delete('/api/resumes/' + id,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`,
                    }
                })
                .then(res => {  this.$store.commit('updateResumes', res.data.resumes); })
                .catch(err => { console.error(err) })
            }
        }
    }
</script>
<style scoped>

    .btn-wrapper {
        text-align: right;
        margin-bottom: 20px;
    }
    table thead, table tbody{
        text-align:center
    }
    table tr td{
        vertical-align:middle
    }
    
</style>

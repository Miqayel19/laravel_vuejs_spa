<template>
    <div  v-if="resume">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ resume.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ resume.name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ resume.desciption }}</td>
                </tr>
            </table>
            <router-link to="/resumes">Back to all resumes</router-link>
    </div>
</template>

<script>
    export default {
        name: 'show',
        created() {
            if (this.resumes.length) {
                this.resume = this.resumes.find((resume) => resume.id == this.$route.params.id);
            } else {
                axios.get(`/api/resumes/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.resume = response.data.resume
                });
            }
        },
        data() {
            return {
                resume: null
            };
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            resumes() {
                return this.$store.getters.resumes;
            }
        },
    }
</script>
<style scoped>

    .resume-view {
        display: flex;
        align-items: center;
    }

</style>
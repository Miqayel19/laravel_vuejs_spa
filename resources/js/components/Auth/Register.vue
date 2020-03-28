<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Register form</div>
                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="form-group row">
                            <label for="email">Name:</label>
                            <input type="text" v-model="form.name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input type="email" v-model="form.email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <input type="submit" value="Register">
                        </div>
                        <div class="form-group row" v-if="regError">
                            <p class="error">
                                {{ regError }}
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {register} from '../../auth';
    export default {
        name: "register",
        data() {
            return {
                form: {
                    name:'',
                    email: '',
                    password: ''
                },
                error: null
            };
        },
        methods: {
            register() {
                register(this.$data.form)
                    .then((res) => {
                        this.$store.commit("regSuccess", res);
                        this.$router.push({path: '/login'});
                    })
                    .catch((error) => {
                        this.$store.commit("regFailed", {error});
                    });
            }
        },
        computed: {
            regError() {
                return this.$store.getters.regError;
            }
        }
    }
</script>

<style scoped>
.error {
    text-align: center;
    color: red;
}
</style>
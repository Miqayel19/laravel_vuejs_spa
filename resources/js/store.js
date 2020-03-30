import {getLoggedinUser} from './auth'

const user = getLoggedinUser();
export default {
    state:{
        welcome:"Welcome to my App",
        currentUser:user,
        auth_error:null,
        isLogged:!!user,
        registeredUser: null,
        reg_error:null,
        resumes:[]
    },
    getters:{
        welcome(state){
            return state.welcome;
        },
        currentUser(state){
            return state.currentUser
        },
        authError(state){
            return state.auth_error
        },
        isLogged(state){
            return state.isLogged
        },
        regError(state){
            return state.reg_error;
        },
        registeredUser(state){
            return state.registeredUser;
        },
        resumes(state){
            return state.resumes
        },
        
    },
    mutations:{
        login(state) {
            state.auth_error = null;
        },

        loginSuccess(state,payload){
            state.isLogged = true
            state.auth_error = null
            state.currentUser = Object.assign({},payload.user,{token:payload.token})
            localStorage.setItem('user',JSON.stringify(state.currentUser))
        },
        loginFailed(state,payload){
            state.isLogged = false
            state.auth_error = payload.error
        },
        regFailed(state,payload){
            state.reg_error = payload.error
        },
        regSuccess(state,payload){
            state.reg_error = null
            state.registeredUser = payload.user;
        },
        logout(state){
            state.isLogged = false
            localStorage.removeItem('user')
            state.currentUser = null
        },
        updateResumes(state,payload){
            state.resumes = payload  
        }
    },
    actions:{
        login(context){
            context.commit('login')
        },
        getResumes(context){
            axios.get('/api/resumes',{
                headers:{
                    'Authorization':`Bearer ${context.state.currentUser.token}`
                }
            })
            .then((response) => {
                context.commit('updateResumes', response.data.resumes);
            })
        }
    }
};
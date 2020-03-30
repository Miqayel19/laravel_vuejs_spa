import Home from './components/Home.vue';
import Register from './components/Auth/Register.vue';
import Login from './components/Auth/Login.vue';
import ResumesMain from './components/resumes/Main.vue';
import ResumesList from './components/resumes/List.vue';
import ResumeNew from './components/resumes/New.vue';
import Resume from './components/resumes/Show.vue';
import ResumeEdit from './components/resumes/Edit.vue';




export const routes = [
{
    path: '/',
    component: Home
},
{
    path: '/register',
    component: Register,
},
{
    path: '/login',
    component: Login,
},
{
    path: '/resumes',
    component: ResumesMain,
    children:[
        {
            path:'/',
            component:ResumesList
        },
        {
            path:'new',
            component:ResumeNew
        },
        {
            path:':id',
            component:Resume
        },
        {
            path:':id/edit',
            component:ResumeEdit
        },

    ]
},
]
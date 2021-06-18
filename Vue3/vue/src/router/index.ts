import Vue from 'vue'
import VueRouter, {Route, RouteConfig} from 'vue-router'
import Page404 from "@/views/Page404.vue";
import Page403 from "@/views/Page403.vue";
import LoginView from "@/modules/auth/views/LoginView.vue";
import RegisterView from "@/modules/auth/views/RegisterView.vue";
import AuthLayout from "@/modules/auth/views/AuthLayout.vue";
import StudentDashboardView from "@/modules/dashboard/views/student/StudentDashboardView.vue";
import MyTasksView from "@/modules/tasks/views/MyTasksView.vue";
import TaskDetailView from "@/modules/tasks/views/TaskDetailView.vue";
import TaskCreateView from "@/modules/tasks/views/TaskCreateView.vue";
import TaskEditView from "@/modules/tasks/views/TaskEditView.vue";
import TaskDetailLayout from "@/modules/tasks/views/TaskDetailLayout.vue";
import LecturerDashboardView from "@/modules/dashboard/views/lecturer/LecturerDashboardView.vue";
import MentorDashboardView from "@/modules/dashboard/views/mentor/MentorDashboardView.vue";
import StudentDashboardLayout from "@/modules/dashboard/views/StudentDashboardLayout.vue";
import LecturerDashboardLayout from "@/modules/dashboard/views/LecturerDashboardLayout.vue";
import MentorDashboardLayout from "@/modules/dashboard/views/MentorDashboardLayout.vue";
import StudentProfileView from "@/modules/profile/views/StudentProfileView.vue";
import MentorFeedback from "@/modules/tasks/views/mentor/MentorFeedback.vue";
import DocentFeedback from "@/modules/tasks/views/docent/DocentFeedback.vue";
import HomeView from "@/modules/Home/views/HomeView.vue";
import ServerError from "@/views/ServerError.vue";

Vue.use(VueRouter)

Vue.router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            component: HomeView,
        },
        {
            path: '/auth',
            component: AuthLayout,
            children: [
                {
                    path: 'login',
                    component: LoginView,
                },
                {
                    path: 'register',
                    component: RegisterView
                }
            ],
        },
        {
            path: '/student',
            component: StudentDashboardLayout,
            children: [
                {
                    path: 'dashboard',
                    component: StudentDashboardView,
                    meta: { requiresAuth: true, role: 'Student'},
                },
                {
                    path: 'mytasks',
                    component: MyTasksView,
                    meta: { requiresAuth: true,  role: 'Student'},
                },
                {
                    path: 'profile',
                    component: StudentProfileView,
                    meta: { requiresAuth: true,  role: 'Student'},
                },
                {
                    path: 'createtask',
                    component: TaskCreateView,
                    meta: { requiresAuth: true, role: 'Student'},
                },
                {
                    path: 'tasks',
                    props : true,
                    component: TaskDetailLayout,
                    children: [
                        {
                            path: ':id',
                            component: TaskDetailView,
                            props : true,
                            meta: { requiresAuth: true, role: 'Student'},
                        },
                        {
                            path: ':id/edit',
                            props : true,
                            name : "edit",
                            component: TaskEditView,
                            meta: { requiresAuth: true, role: 'Student'},
                        },
                    ],
                    meta: {
                        requiresAuth: true, role: 'Student'
                    },
                },
            ],
            meta: { requiresAuth: true,  role: 'Student'},
        },
        {
            path: '/lecturer',
            component: LecturerDashboardLayout,
            children: [
                {
                    path: 'dashboard',
                    component: LecturerDashboardView,
                    meta: { requiresAuth: true,  role: 'Lecturer'},
                },
                {
                    path: 'tasks/:id',
                    props : true,
                    component: DocentFeedback,
                    meta: {
                        requiresAuth: true, role: 'Lecturer'
                    },
                },
            ],
            meta: {
                requiresAuth: true,  role: 'Lecturer'
            },
        },
        {
            path: '/mentor',
            component: MentorDashboardLayout,
            children: [
                {
                    path: 'dashboard',
                    component: MentorDashboardView,
                    meta: { requiresAuth: true, role: 'Mentor'},
                },
                {
                    path: 'tasks/:id',
                    props : true,
                    component: MentorFeedback,
                    meta: {
                        requiresAuth: true, role: 'Mentor'
                    },
                },
            ],
            meta: {
                requiresAuth: true, role: 'Mentor'
            },
        },
        { path: '/403', name: 'no-perm', component: Page403 },
        { path: '/404', name: 'not-found', component: Page404 },
        { path: '*', component: Page404 },
        { path: '/server-error', name: 'serverError', component: ServerError }
    ]
})

Vue.router.beforeEach((to, from, next) => {
    let vue = Vue.router.app;
    if (to.meta.requiresAuth) {
        if (!vue.$auth.ready()) {
            vue.$auth.fetch().then(_ => {
                handleAuthRoute(to, next, vue)
            }).catch(_ => {
                next("/auth/login")
            })
        } else {
            handleAuthRoute(to, next, vue)
        }
    } else {
        next();
    }
});

const handleAuthRoute = (to: Route, next: any, vue: Vue) => {
    if (!vue.$auth.user()) {
        next("/auth/login")
    } else {
        checkRoles(next, to, vue);
    }
}

const checkRoles = async (next: any, to: Route, vue: Vue) => {
    let metadata = to.meta;
    if (!metadata.requiresAuth) {
        next({name: 'no-perm'})
    } else {
        if (metadata.role) {
            await vue.$auth.fetch()
                .then(function(r: any) {
                    if (metadata.role === r.data.data[0].role) {
                        return next()
                    } else {
                        return next({name: 'no-perm'})
                    }
                })
                .catch(_ => {
                    return next({name: 'no-perm'})
                })
        } else {
            next()
        }
    }
}

export default Vue.router

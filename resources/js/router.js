import Menu_types from "./views/Menu_types"
import Dashboard from "./views/Dashboard"
import Layouts from "./components/layouts"
import create_Menu_types from "./views/create_Menu_types"
import edit_Menu_types from "./views/edit_Menu_types"
import Login from "./components/Login"
import Register from "./components/Register"
import Changepassword from "./components/Changepassword"
import Uderdevelopment from "./components/Uderdevelopment"


export default [{
        // mode: 'history',
        // base: 'project/aplarva',
        path: '/',
        component: Layouts,
        name: 'layouts',
        redirect: {
            name: 'dashboard'
        },
        children: [{
                path: 'menu-types',
                component: Menu_types,
                name: 'menu_types'

            },
            {
                path: 'dashboard',
                component: Dashboard,
                name: 'dashboard',
            },
            {
                path: 'menu-types/create',
                component: create_Menu_types,
                name: 'create_Menu_types'

            },
            {
                path: 'menu-types/edit/:id',
                component: edit_Menu_types,
                name: 'edit_Menu_types'

            },
        ]
    },
    {
        path: '/login',
        component: Login,
        name: 'login',

    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
    {
        path: '/changepassword',
        component: Changepassword,
        name: 'changepassword',

    },
    {
        path: '*',
        name: 'Uderdevelopment',
        component: Uderdevelopment
    }

];
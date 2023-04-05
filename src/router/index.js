import Vue from 'vue'
import Router from 'vue-router'


// Containers
const TheContainer = () => import('@/containers/TheContainer')

// Views
const Dashboard = () => import('@/views/Dashboard')

//Login
import Login from '@/views/pages/Login'


const Erot = () => import('@/views/kath-omea/Erotimatologia')

//student
const evaluationStudent = () => import('@/views/student/aksiologishStudent')

//omea
const evaluationKath = () => import('@/views/kath-omea/mathimataKath')
const createErot = () => import('@/views/kath-omea/dhmiourgiaErot')
const questOmea = () => import('@/views/kath-omea/erotOmea')
const myEvaluations = () => import('@/views/kath-omea/aksiologhseis')
const erotimatologiaTmhmatos = () => import('@/views/kath-omea/erotimatologiaTmhmatos')

//modip
const tmhmata = () => import('@/views/modip/tmhmata')
const kathhghtes = () => import('@/views/modip/kathhghtes')
const mathhmata = () => import('@/views/modip/mathhmata')
const erotimatologiaTmhmatwn = () => import('@/views/modip/erotimatologiaTmhmatwn')
const aksiologhseisIdrymatos =() => import('@/views/modip/aksiologhseisIdrymatos')
Vue.use(Router)

export default new Router({
  mode: 'history', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes:configRoutes()
  })

function configRoutes () {
  return [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: TheContainer,
      children: [
        
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        
        {
          path: 'erotimatologia',
          name: 'Question',
          component: Erot
        },

        {
          path: 'student',
          name: 'aksiologishStudent',
          component: evaluationStudent
        },

        {
          path: 'kath-omea',
          redirect: '/kath-omea',
          name: 'kath-omea',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'mathimataKath',
              name: 'Τα μαθήματα μου',
              component: evaluationKath
            },
            {
              path: 'dhmiourgiaErot',
              name: 'Δημιουργία ερωτηματολογίου',
              component: createErot
            },
            {
              path: 'erotOmea',
              name: 'Ερωτηματολόγια',
              component: questOmea
            },
            {
              path: 'aksiologhseis',
              name: 'Αξιολογήσεις μαθημάτων μου',
              component: myEvaluations
            },
            {
              path:'erotimatologiaTmhmatos',
              name:'Ερωτηματολόγια τμήματος',
              component: erotimatologiaTmhmatos
            }
          ]
        },

        {
          path: 'modip',
          redirect: '/modip',
          name: 'modip',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path:'tmhmata',
              name:'Τμήματα ιδρύματος',
              component: tmhmata
            },
            {
              path: 'kathhghtes',
              name: 'Καθηγητές ιδρύματος',
              component: kathhghtes
            },
            {
              path:'mathhmata',
              name:'Μαθήματα ιδρύματος',
              component: mathhmata
            },
            {
              path:'erotimatologiaTmhmatwn',
              name:'Ερωτηματολόγια Τμημάτων',
              component: erotimatologiaTmhmatwn
            },
            {
              path: 'aksiologhseisIdrymatos',
              name:'Αξιολογήσεις μαθημάτων',
              component: aksiologhseisIdrymatos
            }
          ]
        }

      ] 
    },
    {   
      path: '/pages',
      name: 'Login',
      component: Login
    }
   ]
}


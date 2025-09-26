import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue')
  },
{
    path: '/ShowProduct',
    name: 'ShowProduct',
    component: () => import('../views/ShowProduct.vue')
  },
  {
    path: '/customer',
    name: 'customer',
    component: () => import('../views/Customer.vue')
  },
  {
    path: '/add_customer',
    name: 'add_customer',
    component: () => import('../views/Add_customer.vue')
  },
 {
    path: '/product',
    name: 'product',
    component: () => import('../views/Product.vue')
  },
{
    path: '/add_product',
    name: 'add_product',
    component: () => import('../views/Add_product.vue')
  },
{
    path: '/student',
    name: 'student',
    component: () => import('../views/Student.vue')
  },
  {
    path: '/add_student',
    name: 'add_student',
    component: () => import('../views/Add_student.vue')
  },








  
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

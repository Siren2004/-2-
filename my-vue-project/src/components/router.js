import { createRouter, createWebHashHistory } from 'vue-router'
import Student from '@/components/Student.vue'
import Course from '@/components/Course.vue'
import StudentEdit from '@/components/StudentEdit.vue'
import StudentAdd from '@/components/StudentAdd.vue'
import CourseEdit from '@/components/CourseEdit.vue'
import CourseAdd from '@/components/CourseAdd.vue'
import StudentList from '@/components/StudentList.vue'

export default createRouter({
    history: createWebHashHistory(),
    routes: [
        { path: '/Student', component: Student, alias: '/' },
        { path: '/Course', component: Course },
        { path: '/StudentEdit/:id', component: StudentEdit, name: 'StudentEdit' },
        { path: '/StudentAdd', component: StudentAdd },
        { path: '/CourseEdit/:id_direction', component: CourseEdit, name: 'CourseEdit' },
        { path: '/CourseAdd', component: CourseAdd },
        { path: '/StudentList/:id_direction', component: StudentList, name: 'StudentList' },
    ]
})
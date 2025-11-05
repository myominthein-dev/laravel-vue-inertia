<script setup>
import CourseCard from '@/components/CourseCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onMounted,ref } from 'vue';
const page = usePage();
const permissions = page.props.auth.permissions;
const roles  = page.props.auth.roles;
const can = (perm) => {
    return permissions.includes(perm)
}


const user = page.props.auth.user;
const propCourses = user.subscribed_courses
const courses = ref(propCourses)
const subscribedCourseIds = page.props.subscribedCourseIds;

function resetCourses (id) {
    courses.value =  courses.value.filter( c => c.pivot.course_id != id)
}
</script>

<template>
    <AppLayout>
        <h2 class="text-white">Subscribed Courses</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <CourseCard @get-id="resetCourses" v-for="course in courses" :key="course.id" :course="course" :subscribedCourseIds="subscribedCourseIds"/>
        </div>        
    </AppLayout>
</template>

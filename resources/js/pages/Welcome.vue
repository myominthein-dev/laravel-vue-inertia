<script setup>
import CourseCard from '@/components/CourseCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
const page = usePage();
const permissions = page.props.auth.permissions;
const roles  = page.props.auth.roles;
const can = (perm) => {
    return permissions.includes(perm)
}

const courses = page.props.courses
const user = page.props.auth.user;
const subscribedCourseIds = page.props.subscribedCourseIds;


</script>

<template>
    <AppLayout>
        <h2 class="text-white">Courses</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <CourseCard v-for="course in courses" :key="course.id" :course="course" :subscribedCourseIds="subscribedCourseIds" />
        </div>        
    </AppLayout>
</template>

<script setup>
import DataTable from '@/components/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';


const page = usePage();

const courses = page.props.courses;



const breadcrumbs = [
    {
        title: 'Course Management',
        href: '#',
    }
];



</script>

<template>

    <Head title="Course Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <DataTable :name="'course'" :tableHeads="['title','description','slug','category ']" :tableData="courses" />
    </AppLayout>
</template>
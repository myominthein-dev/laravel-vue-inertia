<script setup>
import DataTable from '@/components/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps(["categories"])
const pages = usePage();


const breadcrumbs = [
    
    {
        title: 'Category Management',
        href: route('category'),
    }
]


</script>

<template>
    <Head title="Category Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <DataTable :name="'category'" :tableHeads="['Category Name']" :tableData="props.categories" />
    </AppLayout>
</template>
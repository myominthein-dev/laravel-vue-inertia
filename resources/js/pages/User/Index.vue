<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';


const breadcrumbs = [
    {
        title : "User Management",
        href: '/users',
    }
]
</script>

<template>
   <Head title="User Management" />
   <AppLayout :breadcrumbs="breadcrumbs">
        <section  class="p-4">
            <h1 class="text-2xl font-bold mb-4">User Management</h1>
            <p>Manage your users here.</p>
            <!-- Additional content for user management can be added here -->
        </section>
   </AppLayout>
</template>
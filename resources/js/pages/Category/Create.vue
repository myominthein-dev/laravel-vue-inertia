<script setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Category Management',
        href: route('category'),
    },
    {
        title: 'Category Create',
        href: route('category.create'),
    }
]

const form = useForm({
    name : '',
})

const addCategory = () => {
    form.post(route('category.store'), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}
</script>

<template>
    <Head title="Category Create" />

    <AppLayout :breadcrumbs="breadcrumbs" >
        <h2>Category create</h2>

        <div class="max-w-md mt-10">
            <div>
                <Label for="name" class="mb-2">Category Name</Label>
                <Input id="name" v-model="form.name" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div>
                <Button @click="addCategory()" class="mt-5 cursor-pointer">Create</Button>
            </div>
        </div>
    </AppLayout>
</template>
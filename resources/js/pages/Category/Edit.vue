<script setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const breadcrumbs = [
    {
        title: 'Category Management',
        href: route('category'),
    },
    {
        title: 'Category Edit',
        href: '#',
    }
]

const form = useForm({
    id : page.props.category.id || '',
    name: page.props.category.name  || '',
})

const updateCategory = () => {
    form.put(route('category.update',form.id), {
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
    <Head title="Category Edit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <h2 class="text-2xl font-semibold mb-6">Edit Category</h2>

        <div class="max-w-md mt-10">
            <form @submit.prevent="updateCategory">
                <div>
                    <Label for="name" class="mb-2">Category Name</Label>
                    <Input  id="name" v-model="form.name" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <Button type="submit" class="mt-5 cursor-pointer">Update</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
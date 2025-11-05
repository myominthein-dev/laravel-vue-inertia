<script setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ArrowBigDownIcon, ArrowDown } from 'lucide-vue-next';
import { ref } from 'vue';

const page = usePage();

const categories = page.props.categories;

const breadcrumbs = [
  {
    title: 'Course Management',
    href: route('course.view'),
  },
  {
    title: 'Course Create',
    href: '#',
  } 
]

const selectedCategoryName = ref(null)

const form = useForm({
  title: '',
  description: '',
  slug: '',
  category_id: null
})

const selectCategory = (id) => {
  form.category_id = id

  const selected = categories.find(c => c.id == id)
  selectedCategoryName.value = selected.name
}

const addCourse = () => {
  form.post(route('course.store'), {
    onSuccess: () => {
       selectedCategoryName.value = null
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

  <AppLayout :breadcrumbs="breadcrumbs">
    <h2>Course create</h2>

    <div class="max-w-md mt-10 flex flex-col gap-3">
      <div>
        <Label for="name" class="mb-2">Course Title</Label>
        <Input id="name" v-model="form.title" />
        <InputError :message="form.errors.title" class="mt-2" />
      </div>
      <div>
        <Label for="description" class="mb-2">Description</Label>
        <Input id="description" v-model="form.description" />
        <InputError :message="form.errors.description" class="mt-2" />
      </div>
      <div>
        <Label for="slug" class="mb-2">Slug</Label>
        <Input id="slug" v-model="form.slug" />
        <InputError :message="form.errors.slug" class="mt-2" />
      </div>

      <div class="relative">
        <DropdownMenu>
          <DropdownMenuTrigger class="flex items-center gap-2 border rounded px-4 py-2 ">
            {{ selectedCategoryName || 'Select Category' }}
            <ArrowDown />
          </DropdownMenuTrigger>
          <DropdownMenuContent class="absolute left-0 max-h-[300px] min-w-sm z-50  shadow-lg rounded p-1">
            <DropdownMenuItem v-for="category in categories" :key="category.id" @click="selectCategory(category.id)"
              class="cursor-pointer hover:bg-gray-100 px-2 py-1 rounded">
              {{ category.name }}
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
        <InputError :message="form.errors.category_id" class="mt-1 text-sm text-red-500" />
      </div>
      <div class="mt-5">
        <Button @click="addCourse()" class="mt-5 cursor-pointer">Create</Button>
      </div>
    </div>
  </AppLayout>
</template>
<template>
    <div class="px-4 py-2 border border-gray-100 rounded">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-semibold">{{  course.title }}</h2> <button class="cursor-pointer bg-blue-600 rounded text-white w-36 px-2 py-1" ref="subscribeBtn" v-if="roles.includes('User')" @click="subscribeCourse(course.id)">{{ subscribedCourseIds?.includes(course.id) ? 'Unsubscribe!' : 'Subscribe!' }}</button>
            </div>
            <p class="italic">{{ course.description }}</p>

    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import Button from './ui/button/Button.vue';
import { onMounted, ref, Suspense } from 'vue';

const {course,subscribedCourseIds} = defineProps(['course','subscribedCourseIds'])
const emit = defineEmits(['getId'])
const page = usePage();
const subscribeBtn = ref(null)
const roles = page.props.auth.roles;
const user = page.props.auth.user;
const form = useForm();
const subscribeCourse = (id) => {
    form.post(route('course.subscribe', {id : id}),{
        preserveScroll : true,
        onSuccess : () => {

            if (subscribeBtn.value.innerText == 'Subscribe!') {
                subscribeBtn.value.innerText = 'Unsubscribed!'
            } else {
                subscribeBtn.value.innerText = 'Subscribe!'
            }
            emit('getId',id)
        }
    })
    
}



</script>
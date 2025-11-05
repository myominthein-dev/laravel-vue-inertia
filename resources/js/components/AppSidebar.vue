<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookAIcon, BookIcon, BookImageIcon, BookOpen, Folder, LayoutGrid, LogInIcon, MenuSquareIcon, SaveIcon, User, UserPlus } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'User Management',
        href: '/user',
        icon: User,
    }, {
        title: 'Course Management',
        href: '/course',
        icon: BookAIcon,
    },
    {
        title: 'Category Management',
        href: '/category',
        icon: MenuSquareIcon,
    },

];

const authItems : NavItem[] = [
    {
        title: 'Login',
        href: '/login',
        icon: LogInIcon,
    },
    {
        title: 'Register',
        href: '/register',
        icon: UserPlus,
    },

];

const userItems : NavItem[] = [
    {
        title : 'All Courses',
        href : '/',
        icon :  BookIcon
    },
    {
        title : 'Subscribed Courses',
        href : '/saved-courses',
        icon : SaveIcon
    }
]

const footerNavItems: NavItem[] = [

];

const page = usePage();
const roles = page.props.auth.roles;
const user = page.props.auth.user;
const can = (role) => {
    return roles.includes(role)
}

</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="can('Super Admin') || can('Admin') ? route('dashboard') : route('home')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent v-if="can('Super Admin') || can('Admin')">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarContent v-if="can('User')">
            <NavMain :items="userItems" />
        </SidebarContent>

        <SidebarFooter class="mt-auto">
            <NavFooter :items="footerNavItems" />
            <NavUser v-if="user" />

            <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
                <nav class="flex flex-col items-center justify-end gap-4">
                    <Link v-if="page.props.auth.user && can('dashboard-access')" :href="route('dashboard')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                    Dashboard
                    </Link>
                    <template v-if="!page.props.auth.user">
                        <NavFooter :items="authItems" />
                    </template>
                </nav>
            </header>
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

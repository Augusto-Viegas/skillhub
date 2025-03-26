<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookAIcon, BookHeartIcon, BookOpen, BookPlusIcon, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);

const mainNavItems = computed(() => [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },

    user.value.is_instructor == true ? {
        //Só instrutor pode ver isso
        title: 'Criar curso',
        href: route('courses.create'),
        icon: BookPlusIcon
    } : null,

    user.value.is_instructor == true ? {
        //Só instrutor pode ver isso
        title: 'Meus cursos',
        href: route("courses.myCourses"),
        icon: BookAIcon,
    } : null,

    {
        title: 'Cursos inscritos',
        href: '#',
        icon: BookHeartIcon,
    }
].filter(Boolean));

const footerNavItems = computed(() => [
    user.value.is_instructor == false ? {
        //se ja for instrutor, não pode ver
        title: 'Torne-se um instrutor',
        href: route('user.becomeInstructor'),
        icon: BookAIcon,
    } : null,
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
].filter(Boolean));
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

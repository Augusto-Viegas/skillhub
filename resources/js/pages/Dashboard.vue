<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { computed } from 'vue';

//Pegar os dados da página atual
const page = usePage<{auth: {user: User}}>();

//Criar um valor computado para o nome do usuário
const userName = computed(() => page.props.auth.user.name || 'Visitante');

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: `Seja bem-vindo, ${userName.value}`,
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
                <p>conteúdo das páginas renderiza aqui</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem, type User } from '@/types';
import TableComponent from '@/components/TableComponent.vue';
import { ref, onMounted } from 'vue';

const columns = [
    { label: 'Curso', field: 'title' },
    { label: 'Descrição', field: 'description' },
    { label: 'Preço', field: 'price' },
    { label: 'Ações', field: 'actions' },
];

// Estado da lista de usuários
const courses = ref<{
    id: number;
    title: string;
    description: string;
    price: string;
    image: string;
}[]>([]);
const loading = ref<boolean>(true);

//teste de listagem de itens
onMounted(() => {
    setTimeout(() => {
        courses.value = [
            { id: 1, title: "Teste", description: "descrição teste", price: "5 mabs e konds", image: "https://via.placeholder.com/150" },
            { id: 2, title: "Teste", description: "descrição teste", price: "5 mabs e konds", image: "https://via.placeholder.com/150" },
            { id: 3, title: "Teste", description: "descrição teste", price: "5 mabs e konds", image: "https://via.placeholder.com/150" },
        ];
        loading.value = false;
    }, 2000);
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Meus Cursos',
        href: route('courses.myCourses'),
    },
];
</script>
<template>

    <Head title="Meus Cursos" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
               <Link :href="route('dashboard')"> <TableComponent :columns="columns" :items="courses" :loading="loading" /> </Link>
            </div>
        </div>
    </AppLayout>
</template>
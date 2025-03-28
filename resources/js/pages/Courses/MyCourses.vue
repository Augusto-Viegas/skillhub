<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import TableComponent from '@/components/TableComponent.vue';
import { ref, watchEffect } from 'vue';

const loading = ref<boolean>(true);
const page = usePage();


// Colunas da tabela
const columns = [
    { label: 'Imagem', field: 'image' },
    { label: 'Curso', field: 'title' },
    { label: 'Descrição', field: 'description' },
    { label: 'Preço', field: 'price' },
    { label: 'Ações', field: 'actions' },
    { label: 'data', field: 'created_at' },
];

// Estado da lista de cursos
const courses = ref<{
    id: number;
    title: string;
    description: string;
    price: string;
    image_path: string;
    date: string;
    created_at: string;
}[]>([]);

// Atualiza a lista de usuários
watchEffect(()=>{
    if (page.props.courses && Array.isArray(page.props.courses.data)){
       courses.value = page.props.courses.data;
       loading.value = false;
    }
});

// Breadcrumbs
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
            <div class="relative min-h-[100vh] flex-1
                    rounded-xl border border-sidebar-border/70
                    dark:border-sidebar-border md:min-h-min">
                 <TableComponent :columns="columns" :items="courses" :loading="loading" routeName="courses.edit"/>
            </div>
        </div>
    </AppLayout>
</template>
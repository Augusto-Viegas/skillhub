<script setup lang="ts">
import { defineProps, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

interface Item {
    id: number;
    title: string;
    description: string;
    price: string;
    image_path: string;
    created_at: string;
}

const props = defineProps<{
    columns: { label: string; field: string }[],
    items: Item[];
    loading: boolean;
    routeName: string;
}>();

const items = computed(() => props.items ?? []);
console.log(items.value);
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Skeleton Loader -->
        <div v-if="loading" v-for="i in 6" :key="i" class="bg-gray-200 p-4 rounded-lg animate-pulse h-52"></div>
        <!-- Card do Curso -->
        <div v-else v-for="item in items" :key="item.id" class="bg-white shadow-md rounded-lg 
        border hover:shadow-xl transition overflow-hidden">
            <Link :href="route(props.routeName, { course: item.id })">
                <!-- Thumbnail -->
                <div class="h-40 w-full">
                    <img :src="item.image_path" alt="Thumbnail do Curso" class="w-full h-full object-cover" />
                </div>
                <!-- Conteúdo do Card -->
                <div class="p-4">
                    <h2 class="text-lg font-bold text-gray-900">{{ item.title }}</h2>
                    <p class="text-gray-700 text-sm my-2">{{ item.description }}</p>
                    <p class="text-gray-500 text-sm my-2">{{ item.created_at }}</p>
                    <p class="text-blue-700 font-semibold text-lg">{{ item.price }}</p>
                </div>
            </Link>

        </div>
    </div>
</template>
<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Skeleton Loader -->
        <div v-if="loading" v-for="i in 6" :key="i" class="bg-gray-200 p-4 rounded-lg animate-pulse h-52"></div>

        <!-- Card do Curso -->
        <div v-else v-for="item in items" :key="item.id" class="bg-white shadow-md rounded-lg 
        border hover:shadow-xl transition overflow-hidden">
            <!-- Thumbnail -->
            <div class="h-40 w-full">
                <img :src="item.image" alt="Thumbnail do Curso" class="w-full h-full object-cover" />
            </div>

            <!-- Conteúdo do Card -->
            <div class="p-4">
                <h2 class="text-lg font-bold text-gray-900">{{ item.title }}</h2>
                <p class="text-gray-600 text-sm my-2">{{ item.description }}</p>
                <p class="text-blue-500 font-semibold text-lg">{{ item.price }}</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

interface Item {
    id: number;
    title: string;
    description: string;
    price: string;
    image: string;
}

defineProps<{
    items: Item[];
    loading: boolean;
}>();
</script>
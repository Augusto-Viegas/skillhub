<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const course = page.props.course.data;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Meus Cursos',
        href: route('courses.myCourses'),
    },
    {
        title: course.title,
        href: route('courses.edit', course.id),
    },
]

/**funcionamento da pagina
/*Ainda precisa ser ajeitado a lógica e criar o banco de dados para o funcionamento desejado.
*/

interface Lesson {
    title: string;
    video_url?: string;
}

interface Chapter {
    title: string;
    lessons: Lesson[];
}

// 📌 Recebe o curso como propriedade
const props = defineProps<{
    course: {
        id: number;
        title: string;
        description: string;
        price: string;
        image_path: string;
        chapters: Chapter[];
    }
}>();

// 📌 Cria um formulário reativo
const form = useForm({
    title: props.course.title,
    description: props.course.description,
    price: props.course.price,
    image: null as File | null,
    chapters: props.course.chapters || []
});

// 📌 Controle da aula selecionada
const selectedLesson = ref<Lesson>({ title: "Nenhuma aula selecionada" });

// 📌 Thumbnail Preview
const thumbnailPreview = computed(() =>
    form.image ? URL.createObjectURL(form.image) : props.course.image_path
);

// 📌 Atualiza preview do thumbnail sem salvar
const updateThumbnailPreview = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        form.image = file;
    }
};

// 📌 Adicionar capítulo
const addChapter = () => {
    form.chapters.push({ title: "Novo Capítulo", lessons: [] });
};

// 📌 Remover capítulo
const removeChapter = (index: number) => {
    form.chapters.splice(index, 1);
};

// 📌 Adicionar aula em um capítulo específico
const addLesson = (chapterIndex: number) => {
    form.chapters[chapterIndex].lessons.push({ title: "Nova Aula", video_url: "" });
};

// 📌 Remover aula de um capítulo
const removeLesson = (chapterIndex: number, lessonIndex: number) => {
    form.chapters[chapterIndex].lessons.splice(lessonIndex, 1);
};

// 📌 Enviar os dados para o backend
const submit = () => {
    form.post(route("courses.update", { course: props.course.id }), {
        preserveScroll: true,
    });
};


</script>

<template>

    <Head title="{{course.title}}" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex flex-col h-screen">

                    <!-- TOPO DA PÁGINA -->
                    <div class="p-6 bg-gray-100 shadow-md border-b gap-4 justify-center flex items-center">
                        Editar informações do curso
                    </div>
                    <div class="p-6 bg-white shadow-md border-b flex items-center gap-4">
                        <!-- Nome atual do curso (não editável) -->
                        <h1 class="text-2xl font-bold text-gray-800">
                            {{ course.title }}
                        </h1>

                        <!-- Input editável para o título -->
                        <input v-model="form.title"
                            class="text-2xl font-semibold text-gray-500 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                            placeholder="Edite o título do curso..." />
                    </div>

                    <!-- 📌 Corpo - Player e Sidebar -->
                    <div class="flex flex-1">
                        <!-- 📌 Player de Vídeo (50%) -->
                        <div class="w-2/3 bg-black flex items-center justify-center">
                            <video v-if="selectedLesson.video_url" controls class="w-full h-full object-cover">
                                <source :src="selectedLesson.video_url" type="video/mp4">
                                Seu navegador não suporta a reprodução de vídeos.
                            </video>
                            <p v-else class="text-white">Selecione uma aula para visualizar o vídeo.</p>
                        </div>

                        <!-- 📌 Sidebar de Capítulos e Aulas (30%) -->
                        <aside class="w-1/3 bg-gray-100 p-4 border-l overflow-y-auto max-h-[50vh]">
                            <h2 class="text-xl font-bold mb-4">Capítulos</h2>

                            <div v-for="(chapter, index) in form.chapters" :key="index"
                                class="mb-4 bg-white p-3 rounded shadow">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-semibold">{{ chapter.title }}</h3>
                                    <button @click="removeChapter(index)"
                                        class="text-red-500 hover:text-red-700">✖</button>
                                </div>

                                <!-- Botão para adicionar aula -->
                                <button @click="addLesson(index)"
                                    class="mt-2 bg-blue-500 text-white px-2 py-1 rounded text-sm">
                                    + Adicionar Aula
                                </button>

                                <!-- Lista de Aulas -->
                                <ul class="mt-2">
                                    <li v-for="(lesson, lessonIndex) in chapter.lessons" :key="lessonIndex"
                                        class="bg-gray-200 p-2 rounded mt-2 flex justify-between cursor-pointer hover:bg-gray-300"
                                        @click="selectedLesson = lesson">
                                        <span>{{ lesson.title }}</span>
                                        <button @click.stop="removeLesson(index, lessonIndex)"
                                            class="text-red-500 hover:text-red-700 text-xs">✖</button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Botão para adicionar capítulo -->
                            <button @click="addChapter" class="w-full bg-green-500 text-white py-2 rounded">
                                + Adicionar Capítulo
                            </button>
                        </aside>
                    </div>

                    <!-- 📌 Parte Inferior - Informações do Curso -->
                    <main class="h-1/2 p-6 bg-white border-t shadow">
                        <h2 class="text-2xl font-bold mb-4">Editar Informações do Curso</h2>

                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- 📌 Descrição -->
                                <div class="md:col-span-2">
                                    <label class="block font-semibold mb-1">Descrição</label>
                                    <textarea v-model="form.description"
                                        class="w-full border rounded px-3 py-2 h-24"></textarea>
                                </div>

                                <!-- 📌 Preço -->
                                <div>
                                    <label class="block font-semibold mb-1">Preço</label>
                                    <input v-model="form.price" type="text" class="w-full border rounded px-3 py-2">
                                </div>

                                <!-- 📌 Thumbnail -->
                                <div>
                                    <label class="block font-semibold mb-1">Thumbnail</label>
                                    <div class="flex items-center gap-4">
                                        <img :src="thumbnailPreview" alt="Thumbnail"
                                            class="w-32 h-32 object-cover rounded border">
                                        <input type="file" @change="updateThumbnailPreview" accept="image/*"
                                            class="border rounded px-3 py-2">
                                    </div>
                                </div>
                            </div>

                            <!-- 📌 Botão de Salvar -->
                            <button type="submit"
                                class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Salvar Curso
                            </button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

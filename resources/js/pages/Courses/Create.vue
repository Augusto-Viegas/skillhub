<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();
const user = page.props.auth.user;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Create Course',
        href: route('courses.create'),
    },
];


const form = useForm({
    instructor_id: user.id,
    title: '',
    description: '',
    image_path: null as File | null,
    price: '',
});

const submit = () => {
    form.post(route('courses.store'), {
        onSuccess: () => {
            form.reset();
        },
        onFinish: () => {
            form.image_path = null;
        }
    });
};

//Função para lidar com o upload de arquivos
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.image_path = target.files[0];
    };
};

//Estado para exibir o preço formatado
const formattedPrice = computed({
    get: () => {
        return form.price ? formatToCurrency(form.price) : '';
    },
    set: (value) => {
        form.price = cleanCurrencyInput(value);
    }
})

//Função para formatar um número como moeda (R$)
const formatToCurrency = (value: string | number) => {
    const num = Number(value);
    return num.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

//Função para limpar a formatação de moeda
const cleanCurrencyInput = (value: string) => {
    const numericValue = Number(value.replace(/\D/g, '')) / 100; // Garante duas casas decimais
    return numericValue.toFixed(2); // Mantém o formato correto para o banco
}

</script>

<template>

    <Head title="Novo curso" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <form @submit.prevent="submit" class="flex flex-col gap-6 p-6 rounded-xl
                    border border-sidebar-border/70 dark:border-sidebar-border
                    max-w-screen-md	w-full mx-auto mt-4">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="title">Titulo do curso</Label>
                            <Input id="title" type="text" required autofocus :tabindex="1" v-model="form.title"
                                placeholder="Nome do curso" />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="description">Descrição do curso</Label>
                            <textarea id="description" required :tabindex="2" v-model="form.description" rows="7"
                                placeholder="Descrição do curso" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg 
                                dark:bg-gray-800 dark:text-gray-200 resize-none"></textarea>
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="image_path">Thumbnail</Label>
                            <Input id="image_path" type="file" :tabindex="2" @change="handleFileUpload" />
                            <InputError :message="form.errors.image_path" />
                        </div>

                        <div class="flex items-center gap-2 w-1/2">
                            <Label for="price"
                                class="text-sm font-semibold text-gray-700 dark:text-gray-400 whitespace-nowrap">
                                Valor:
                            </Label>
                            <div class="relative w-full">
                                <Input id="price" type="text" required :tabindex="3" v-model="formattedPrice"
                                    placeholder="0,00" class="w-full pl-8 pr-3 py-1.5 border border-gray-300
                                    dark:border-gray-600 rounded-lg 
                                    focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-gray-600 
                                    dark:bg-gray-800 dark:text-gray-200" />
                            </div>
                            <InputError :message="form.errors.price" class="text-sm text-red-500" />
                        </div>

                        <Button @click="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Criar curso
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
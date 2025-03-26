<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
/**
 * A lógica precisa ser reativa para que possa procurar tanto todos os cursos no index
 * como os cursos que o instrutor criou na página de meus cursos, assim como os cursos
 * em que o usuário é inscrito, apenas, na sua devida página
 */
</script>

<template>
    <div class="">
        <div class="flex items-center rounded-md bg-white
            pl-3 outline-1 -outline-offset-1 outline-gray-300
            has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2
             has-[input:focus-within]:outline-indigo-600">
             
            <Label for="searchBar" class="m-auto mr-2">Procurar curso</Label>
            <Input type="text" name="searchBar" id="searchBar"
                class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base 
                text-gray-900 placeholder:text-black-400 focus:outline-none sm:text-sm/6
                mr-2"
             />

             <Button type="submit" class="">Procurar</Button>
        </div>
    </div>
</template>
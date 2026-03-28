<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Editar Projeto</h1>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4 max-w-lg">
      <div>
        <label class="block text-sm font-medium mb-1">Nome *</label>
        <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Descrição</label>
        <textarea v-model="form.description" class="w-full border rounded px-3 py-2" rows="3" />
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Status *</label>
        <select v-model="form.status" class="w-full border rounded px-3 py-2">
          <option value="active">Ativo</option>
          <option value="inactive">Inativo</option>
          <option value="completed">Concluído</option>
        </select>
      </div>
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Atualizar
      </button>
    </form>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ project: Object, companies: Array });
const form = useForm({
  name:        props.project.name,
  description: props.project.description ?? '',
  status:      props.project.status,
});
const submit = () => form.put(`/projects/${props.project.id}`);
</script>
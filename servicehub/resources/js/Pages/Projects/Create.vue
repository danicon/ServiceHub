<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Novo Projeto</h1>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4 max-w-lg">
      <div>
        <label class="block text-sm font-medium mb-1">Empresa *</label>
        <select v-model="form.company_id" class="w-full border rounded px-3 py-2">
          <option value="">Selecione...</option>
          <option v-for="c in companies" :key="c.id" :value="c.id">{{ c.name }}</option>
        </select>
        <p v-if="form.errors.company_id" class="text-red-500 text-xs mt-1">{{ form.errors.company_id }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Nome *</label>
        <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
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
        Salvar
      </button>
    </form>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({ companies: Array });
const form = useForm({ company_id: '', name: '', description: '', status: 'active' });
const submit = () => form.post('/projects');
</script>
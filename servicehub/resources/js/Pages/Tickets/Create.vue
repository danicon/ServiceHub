<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Novo Ticket</h1>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4 max-w-lg">
      <div>
        <label class="block text-sm font-medium mb-1">Projeto *</label>
        <select v-model="form.project_id" class="w-full border rounded px-3 py-2">
          <option value="">Selecione...</option>
          <option v-for="p in projects" :key="p.id" :value="p.id">
            {{ p.company?.name }} — {{ p.name }}
          </option>
        </select>
        <p v-if="form.errors.project_id" class="text-red-500 text-xs mt-1">{{ form.errors.project_id }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Título *</label>
        <input v-model="form.title" type="text" class="w-full border rounded px-3 py-2" />
        <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Descrição</label>
        <textarea v-model="form.description" class="w-full border rounded px-3 py-2" rows="3" />
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Prioridade *</label>
        <select v-model="form.priority" class="w-full border rounded px-3 py-2">
          <option value="low">Baixa</option>
          <option value="medium">Média</option>
          <option value="high">Alta</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Anexo (JSON ou TXT)</label>
        <input type="file" accept=".json,.txt" @change="form.attachment = $event.target.files[0]"
          class="w-full border rounded px-3 py-2" />
      </div>
      <button type="submit" :disabled="form.processing"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 disabled:opacity-50">
        {{ form.processing ? 'Salvando...' : 'Salvar' }}
      </button>
    </form>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({ projects: Array });

const form = useForm({
  project_id:  '',
  title:       '',
  description: '',
  priority:    'medium',
  attachment:  null,
});

const submit = () => form.post('/tickets', { forceFormData: true });
</script>
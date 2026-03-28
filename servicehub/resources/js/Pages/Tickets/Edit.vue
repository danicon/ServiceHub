<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Editar Ticket</h1>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4 max-w-lg">
      <div>
        <label class="block text-sm font-medium mb-1">Título *</label>
        <input v-model="form.title" type="text" class="w-full border rounded px-3 py-2" />
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
        <label class="block text-sm font-medium mb-1">Status *</label>
        <select v-model="form.status" class="w-full border rounded px-3 py-2">
          <option value="open">Aberto</option>
          <option value="in_progress">Em andamento</option>
          <option value="closed">Fechado</option>
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

const props = defineProps({ ticket: Object, projects: Array });
const form = useForm({
  title:       props.ticket.title,
  description: props.ticket.description ?? '',
  priority:    props.ticket.priority,
  status:      props.ticket.status,
});
const submit = () => form.put(`/tickets/${props.ticket.id}`);
</script>
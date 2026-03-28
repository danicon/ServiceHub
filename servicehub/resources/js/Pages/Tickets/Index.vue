<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Tickets</h1>
      <Link href="/tickets/create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Novo Ticket
      </Link>
    </div>
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
          <tr>
            <th class="px-4 py-3">Título</th>
            <th class="px-4 py-3">Projeto</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Prioridade</th>
            <th class="px-4 py-3">Responsável</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets" :key="ticket.id" class="border-t hover:bg-gray-50">
            <td class="px-4 py-3 font-medium">{{ ticket.title }}</td>
            <td class="px-4 py-3">{{ ticket.project?.name }}</td>
            <td class="px-4 py-3">
              <span :class="statusClass(ticket.status)" class="px-2 py-1 rounded text-xs font-medium">
                {{ ticket.status }}
              </span>
            </td>
            <td class="px-4 py-3">
              <span :class="priorityClass(ticket.priority)" class="px-2 py-1 rounded text-xs font-medium">
                {{ ticket.priority }}
              </span>
            </td>
            <td class="px-4 py-3">{{ ticket.user?.name }}</td>
            <td class="px-4 py-3 flex gap-3">
              <Link :href="`/tickets/${ticket.id}`" class="text-indigo-600 hover:underline">Ver</Link>
              <Link :href="`/tickets/${ticket.id}/edit`" class="text-yellow-600 hover:underline">Editar</Link>
              <button @click="destroy(ticket.id)" class="text-red-500 hover:underline">Excluir</button>
            </td>
          </tr>
          <tr v-if="!tickets.length">
            <td colspan="6" class="px-4 py-3 text-gray-400 text-center">Nenhum ticket ainda.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({ tickets: Array });

function statusClass(s) {
  return { open: 'bg-blue-100 text-blue-700', in_progress: 'bg-yellow-100 text-yellow-700', closed: 'bg-gray-100 text-gray-600' }[s] ?? '';
}
function priorityClass(p) {
  return { low: 'bg-green-100 text-green-700', medium: 'bg-yellow-100 text-yellow-700', high: 'bg-red-100 text-red-700' }[p] ?? '';
}
function destroy(id) {
  if (confirm('Excluir ticket?')) router.delete(`/tickets/${id}`);
}
</script>
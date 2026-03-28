<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Projetos</h1>
      <Link href="/projects/create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Novo Projeto
      </Link>
    </div>
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
          <tr>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Empresa</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Tickets</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="project in projects" :key="project.id" class="border-t hover:bg-gray-50">
            <td class="px-4 py-3 font-medium">{{ project.name }}</td>
            <td class="px-4 py-3">{{ project.company?.name }}</td>
            <td class="px-4 py-3">
              <span :class="statusClass(project.status)" class="px-2 py-1 rounded text-xs font-medium">
                {{ project.status }}
              </span>
            </td>
            <td class="px-4 py-3">{{ project.tickets_count }}</td>
            <td class="px-4 py-3 flex gap-3">
              <Link :href="`/projects/${project.id}`" class="text-indigo-600 hover:underline">Ver</Link>
              <Link :href="`/projects/${project.id}/edit`" class="text-yellow-600 hover:underline">Editar</Link>
              <button @click="destroy(project.id)" class="text-red-500 hover:underline">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({ projects: Array });

function statusClass(status) {
  return {
    active:    'bg-green-100 text-green-700',
    inactive:  'bg-gray-100 text-gray-600',
    completed: 'bg-blue-100 text-blue-700',
  }[status] ?? '';
}

function destroy(id) {
  if (confirm('Excluir projeto?')) router.delete(`/projects/${id}`);
}
</script>
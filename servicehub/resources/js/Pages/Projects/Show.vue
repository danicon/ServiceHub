<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ project.name }}</h1>
      <Link href="/projects" class="text-sm text-indigo-600 hover:underline">← Voltar</Link>
    </div>
    <div class="bg-white rounded shadow p-6 mb-6">
      <p><span class="font-medium">Empresa:</span> {{ project.company?.name }}</p>
      <p><span class="font-medium">Status:</span> {{ project.status }}</p>
      <p v-if="project.description"><span class="font-medium">Descrição:</span> {{ project.description }}</p>
    </div>
    <h2 class="text-lg font-semibold mb-3">Tickets</h2>
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
          <tr>
            <th class="px-4 py-3">Título</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Prioridade</th>
            <th class="px-4 py-3">Responsável</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in project.tickets" :key="ticket.id" class="border-t">
            <td class="px-4 py-3">{{ ticket.title }}</td>
            <td class="px-4 py-3">{{ ticket.status }}</td>
            <td class="px-4 py-3">{{ ticket.priority }}</td>
            <td class="px-4 py-3">{{ ticket.user?.name }}</td>
            <td class="px-4 py-3">
              <Link :href="`/tickets/${ticket.id}`" class="text-indigo-600 hover:underline">Ver</Link>
            </td>
          </tr>
          <tr v-if="!project.tickets.length">
            <td colspan="5" class="px-4 py-3 text-gray-400">Nenhum ticket.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ project: Object });
</script>
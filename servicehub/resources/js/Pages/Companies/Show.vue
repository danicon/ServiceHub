<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ company.name }}</h1>
      <Link href="/companies" class="text-sm text-indigo-600 hover:underline">← Voltar</Link>
    </div>
    <div class="bg-white rounded shadow p-6 mb-6">
      <p><span class="font-medium">E-mail:</span> {{ company.email }}</p>
      <p><span class="font-medium">Telefone:</span> {{ company.phone ?? '—' }}</p>
    </div>
    <h2 class="text-lg font-semibold mb-3">Projetos</h2>
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
          <tr>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="project in company.projects" :key="project.id" class="border-t">
            <td class="px-4 py-3">{{ project.name }}</td>
            <td class="px-4 py-3">{{ project.status }}</td>
            <td class="px-4 py-3">
              <Link :href="`/projects/${project.id}`" class="text-indigo-600 hover:underline">Ver</Link>
            </td>
          </tr>
          <tr v-if="!company.projects.length">
            <td colspan="3" class="px-4 py-3 text-gray-400">Nenhum projeto.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ company: Object });
</script>
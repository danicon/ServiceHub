<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Empresas</h1>
      <Link href="/companies/create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Nova Empresa
      </Link>
    </div>
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
          <tr>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">E-mail</th>
            <th class="px-4 py-3">Telefone</th>
            <th class="px-4 py-3">Projetos</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="company in companies" :key="company.id" class="border-t hover:bg-gray-50">
            <td class="px-4 py-3 font-medium">{{ company.name }}</td>
            <td class="px-4 py-3">{{ company.email }}</td>
            <td class="px-4 py-3">{{ company.phone ?? '—' }}</td>
            <td class="px-4 py-3">{{ company.projects_count }}</td>
            <td class="px-4 py-3 flex gap-3">
              <Link :href="`/companies/${company.id}`" class="text-indigo-600 hover:underline">Ver</Link>
              <Link :href="`/companies/${company.id}/edit`" class="text-yellow-600 hover:underline">Editar</Link>
              <button @click="destroy(company.id)" class="text-red-500 hover:underline">Excluir</button>
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

defineProps({ companies: Array });

function destroy(id) {
  if (confirm('Excluir empresa?')) {
    router.delete(`/companies/${id}`);
  }
}
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ ticket.title }}</h1>
      <Link href="/tickets" class="text-sm text-indigo-600 hover:underline">← Voltar</Link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-white rounded shadow p-6">
        <h2 class="font-semibold text-lg mb-3">Informações</h2>
        <p><span class="font-medium">Projeto:</span> {{ ticket.project?.name }}</p>
        <p><span class="font-medium">Empresa:</span> {{ ticket.project?.company?.name }}</p>
        <p><span class="font-medium">Status:</span> {{ ticket.status }}</p>
        <p><span class="font-medium">Prioridade:</span> {{ ticket.priority }}</p>
        <p v-if="ticket.description" class="mt-2">{{ ticket.description }}</p>
      </div>
      <div class="bg-white rounded shadow p-6">
        <h2 class="font-semibold text-lg mb-3">Responsável</h2>
        <p><span class="font-medium">Nome:</span> {{ ticket.user?.name }}</p>
        <p><span class="font-medium">E-mail:</span> {{ ticket.user?.email }}</p>
        <p v-if="ticket.user?.profile?.position">
          <span class="font-medium">Cargo:</span> {{ ticket.user.profile.position }}
        </p>
        <p v-if="ticket.user?.profile?.phone">
          <span class="font-medium">Telefone:</span> {{ ticket.user.profile.phone }}
        </p>
      </div>
    </div>

    <div v-if="ticket.detail" class="bg-white rounded shadow p-6">
      <h2 class="font-semibold text-lg mb-3">Detalhes Técnicos</h2>
      <p v-if="ticket.detail.technical_notes">
        <span class="font-medium">Notas:</span> {{ ticket.detail.technical_notes }}
      </p>
      <p v-if="ticket.detail.responsible_email">
        <span class="font-medium">E-mail responsável:</span> {{ ticket.detail.responsible_email }}
      </p>
      <p v-if="ticket.detail.processed_at">
        <span class="font-medium">Processado em:</span> {{ ticket.detail.processed_at }}
      </p>
      <div v-if="ticket.detail.enriched_data" class="mt-3">
        <span class="font-medium">Dados enriquecidos:</span>
        <pre class="bg-gray-50 rounded p-3 mt-1 text-xs overflow-auto">{{ JSON.stringify(ticket.detail.enriched_data, null, 2) }}</pre>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ ticket: Object });
</script>
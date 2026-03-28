<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Editar Empresa</h1>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4 max-w-lg">
      <div>
        <label class="block text-sm font-medium mb-1">Nome *</label>
        <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">E-mail *</label>
        <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" />
        <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Telefone</label>
        <input v-model="form.phone" type="text" class="w-full border rounded px-3 py-2" />
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

const props = defineProps({ company: Object });
const form = useForm({
  name:  props.company.name,
  email: props.company.email,
  phone: props.company.phone ?? '',
});
const submit = () => form.put(`/companies/${props.company.id}`);
</script>
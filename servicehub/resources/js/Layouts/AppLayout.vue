<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow px-6 py-4 flex gap-6 items-center">
      <span class="font-bold text-lg text-indigo-600">ServiceHub</span>
      <Link href="/companies" class="text-sm text-gray-600 hover:text-indigo-600">Empresas</Link>
      <Link href="/projects" class="text-sm text-gray-600 hover:text-indigo-600">Projetos</Link>
      <Link href="/tickets" class="text-sm text-gray-600 hover:text-indigo-600">Tickets</Link>
      <div class="ml-auto flex gap-4 items-center">
        <span class="text-sm text-gray-500">{{ $page.props.auth.user?.name }}</span>
        <Link href="/logout" method="post" as="button" class="text-sm text-red-500 hover:underline">
          Sair
        </Link>
      </div>
    </nav>
    <main class="max-w-6xl mx-auto py-8 px-4">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
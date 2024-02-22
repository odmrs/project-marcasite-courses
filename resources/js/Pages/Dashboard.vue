<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Courses" />
    <AuthenticatedLayout>
      <template #header>
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">Listagem dos inscritos</h2>
      </template>
      <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">   
        <div class="flex justify-center w-full">
            #TODO
          </div>
      </div>
    </AuthenticatedLayout>
  </template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Courses" />
    <AuthenticatedLayout>
      <template #header>
              <h2 class="font-semibold text-xl text-gray-800 leading-tight" v-if="$page.props.auth.user && $page.props.auth.user.is_admin">Bem vindo Administrador!</h2>
              <h2 class="font-semibold text-xl text-gray-800 leading-tight" v-else>Bem vindo Usuario!</h2>
      </template>
      <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">   
        <div class="flex justify-center w-full">
            #TODO
          </div>
      </div>
    </AuthenticatedLayout>
  </template>

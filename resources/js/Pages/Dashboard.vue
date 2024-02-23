<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const { studentStatus } = usePage();
const currentStatus = ref(studentStatus);
</script>


<template>
  <Head title="Courses" />
  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight" v-if="$page.props.auth.user.is_admin">Bem vindo Administrador!</h2>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight" v-else>Bem vindo Usuario!</h2>
      </template>
      <div v-if="$page.props.auth.user.is_admin">
          <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
              <div class="text-center">
                  <h1 class="text-4xl font-bold text-gray-800 mb-4">Bem-vindo!</h1>
                  <p class="text-lg text-gray-600">Vamos ao trabalho!</p>
                  <div class="flex justify-center items-center">
                      <img src="/storage/images/center-image.png" alt="Marcasite Logo criada por Marcos" style="max-width: 35%; height: auto;">
                  </div>
              </div>
          </div>
      </div>
      <div v-else>
        <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
              <div class="text-center">
                  <h1 class="text-4xl font-bold text-gray-800 mb-4">Bem-vindo!</h1>
                  <p class="text-lg text-gray-600">Bons estudos!</p>
                  <div class="flex justify-center items-center">
                      <img src="/storage/images/center-image.png" alt="Marcasite Logo criada por Marcos" style="max-width: 35%; height: auto;">
                  </div>
              </div>
          </div>
      </div> 
  </AuthenticatedLayout>
</template>
<script setup>
    import { Head, InertiaLink } from '@inertiajs/inertia-vue3';
</script>
  
<template>
    <Head title="Courses" />
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
      <div class="bg-white p-6 md:w-1/2 rounded-lg shadow-md">
        <svg viewBox="0 0 24 24" class="text-green-600 w-16 h-16 mx-auto my-6">
          <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"></path>
        </svg>
        <div class="text-center">
          <h3 class="md:text-2xl text-base text-gray-900 font-semibold">Pagamento feito!</h3>
          <p class="text-gray-600 my-2">Obrigado por comprar nossos cursos!</p>
          <p class="text-gray-600">Tenha um ótimo dia!</p>
          <div class="py-10 text-center">
            <InertiaLink :href="route('dashboard')" class="px-12 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-full">
                Voltar
            </InertiaLink>
          </div>
        </div>
      </div>
    </div>
  </template>

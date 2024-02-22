<script setup>
    import { Head, InertiaLink } from '@inertiajs/inertia-vue3';
</script>
  
<template>
    <Head title="Courses" />
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
      <div class="bg-white p-6 md:w-1/2 rounded-lg shadow-md">
        <svg viewBox="0 0 48 48" class="text-red-600 w-16 h-16 mx-auto my-6">
  <circle cx="24" cy="24" r="20" fill="#FED7D7" />
  <path fill="currentColor" d="M34.121,34.121a1,1,0,0,1-1.414,0L24,25.414l-8.707,8.707a1,1,0,1,1-1.414-1.414L22.586,24,13.879,15.293a1,1,0,0,1,1.414-1.414L24,22.586l8.707-8.707a1,1,0,0,1,1.414,1.414L25.414,24Z"></path>
</svg>



        <div class="text-center">
          <h3 class="md:text-2xl text-base text-gray-900 font-semibold">Pagamento feito!</h3>
          <p class="text-gray-600 my-2">Obrigado por comprar nossos cursos!</p>
          <p class="text-gray-600">Tenha um ótimo dia!</p>
          <div class="py-10 text-center">
            <InertiaLink :href="route('stripe.index')" class="px-12 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-full">
                Voltar
            </InertiaLink>
          </div>
        </div>
      </div>
    </div>
  </template>

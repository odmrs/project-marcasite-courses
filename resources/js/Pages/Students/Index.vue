<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, InertiaLink } from '@inertiajs/inertia-vue3';

defineProps(['students']);

</script>

<template>
  <Head title="Courses" />
    <AuthenticatedLayout>
  <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">   
        <div class="flex justify-center w-full" v-if="$page.props.auth.user.is_admin">
          <InertiaLink :href="route('students.create')" class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-blue-200 hover:text-black text-black underline">Criar novo estudante</InertiaLink>
        </div>
      </div>
  <div class="container mx-auto p-6 flex flex-col items-center">
    <!-- Campo de busca e filtro de categorias -->
    <div class="mb-4 flex justify-between w-full max-w-4xl">
      <input type="text" placeholder="Buscar" class="w-1/2 px-3 py-2 border rounded-md">
      <select class="w-1/4 px-3 py-2 border rounded-md">
        <option value="">Todas as categorias</option>
        <!-- Opções de categorias aqui -->
      </select>
    </div>
    <!-- Tabela -->
    <div class="w-full max-w-4xl overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrito</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de inscrição</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="student in students" :key="student.id">
            <td class="px-6 py-4 whitespace-nowrap">{{ student.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ student.created_at ? new Date(student.created_at).toLocaleDateString('pt-BR') : '' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ student.userType }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ student.cpf }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ student.email }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ student.address }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ student.status }}</td>
            <td class="px-6 py-4 whitespace-nowrap">R$ #todo</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
              /
              <button class="text-red-600 hover:text-red-900">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</AuthenticatedLayout>
</template>

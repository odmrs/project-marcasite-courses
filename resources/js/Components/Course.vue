<script setup>
defineProps(['course']);
</script>
 
<template>
    <div class="container mx-auto p-6 flex flex-col items-center">
      <div class="w-full max-w-4xl">
        <div class="flex justify-between items-center mb-6">
          <div>
            <span class="text-gray-800">{{ course.user.name }}</span>
            <small class="ml-2 text-sm text-gray-600">{{ new Date(course.created_at).toLocaleString() }}</small>
          </div>
        </div>
        <div class="w-full overflow-x-auto">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2">Nome do Curso</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Preço</th>
                <th class="px-4 py-2">Data de Início</th>
                <th class="px-4 py-2">Data de Término</th>
                <th class="px-4 py-2">Max. de Alunos</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="px-4 py-2">{{ course.course_name }}</td>
                <td class="px-4 py-2">{{ course.course_description }}</td>
                <td class="px-4 py-2">{{ course.course_price }}</td>
                <td class="px-4 py-2">{{ course.start_date }}</td>
                <td class="px-4 py-2">{{ course.end_date }}</td>
                <td class="px-4 py-2">{{ course.max_students }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm } from '@inertiajs/vue3';

import { ref } from 'vue';

const updateEndDateMin = () => {
    form.end_date = form.start_date;
};


const props = defineProps(['course']);

const form = useForm({
    course_name: props.course.course_name,
    course_description: props.course.course_description,
    course_price: props.course.course_price,
    start_date: props.course.start_date,
    end_date: props.course.end_date,
    max_students: props.course.max_students,
    file_upload: props.course.file_upload,
    remember: false
});

const editing = ref(false);
</script>
 
<template>
  <div class="container mx-auto p-6 flex flex-col items-center">
    <div class="w-full max-w-full">
      <div class="flex justify-between items-center mb-6">
        <div>
          <span class="text-gray-800">{{ course.user.name }}</span>
          <small class="ml-2 text-sm text-gray-600">{{ new Date(course.created_at).toLocaleString() }}</small>
          <small v-if="course.created_at !== course.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
        </div>
                <Dropdown v-if="$page.props.auth.user.is_admin">
                  <template #trigger>
                      <button>
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">

                              <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                          </svg>
                      </button>
                  </template>
                  <template #content>
                      <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                          Editar
                      </button>
                      <DropdownLink as="button" :href="route('courses.destroy', course.id)" method="delete"
                      class="text-red-600 hover:bg-red-100 hover:text-red-900">
                      Deletar
                      </DropdownLink>
                  </template>
                </Dropdown>
              </div>
              <!-- Start of form -->
              <form v-if="editing" @submit.prevent="form.put(route('courses.update', { course: course.id }), { onSuccess: () => editing = false })" enctype="multipart/form-data">
                <!-- course name  -->
                <div class="mt-4">
                  <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                  <input v-model="form.course_name" type="text" id="course_name" name="course_name" class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                  <InputError :course_name="form.errors.course_name" class="mt-2" />
                </div>
                <!-- course description  -->
                <div class="mt-4">
                  <label for="course_description" class="block text-sm font-medium text-gray-700">Course Description</label>
                  <textarea v-model="form.course_description" id="course_description" name="course_description" rows="4" class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                  <InputError :course_description="form.errors.course_description" class="mt-2" />
                </div>
                <!-- course price  -->
                <div class="mt-4">
                  <label for="course_price" class="block text-sm font-medium text-gray-700">Course Price</label>
                  <input v-model="form.course_price" type="number" id="course_price" name="course_price" class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                  <InputError :course_price="form.errors.course_price" class="mt-2" />
                </div>
                <!-- start date  -->
                <div class="mt-4">
                  <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                  <input 
                    v-model="form.start_date" 
                    type="date" 
                    id="start_date" 
                    name="start_date" 
                    class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    @change="updateEndDateMin"
                  >
                  <InputError :start_date="form.errors.start_date" class="mt-2" />
                </div>
                <!-- end date  -->
                <div class="mt-4">
                  <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                  <input 
                    v-model="form.end_date" 
                    type="date" 
                    id="end_date" 
                    name="end_date" 
                    class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    :min="form.start_date"
                  >
                  <InputError :end_date="form.errors.end_date" class="mt-2" />
                </div>
                <!-- max students  -->
                <div class="mt-4">
                  <label for="max_students" class="block text-sm font-medium text-gray-700">Max Students</label>
                  <input v-model="form.max_students" type="number" id="max_students" name="max_students" class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" min="5">
                  <InputError :max_students="form.errors.max_students" class="mt-2" />
                </div>
                <!-- add file  -->
                <div class="mt-4">
                    <label for="file_upload" class="block text-sm font-medium text-gray-700">Upload de arquivo</label>
                    <input 
                        type="file" 
                        id="file_upload" 
                        name="file_upload" 
                        class="mt-1 p-2 block w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        accept=".pdf,.doc,.docx"
                        @change="handleFileUpload"
                    >
                    <InputError :file_upload="form.errors.file_upload" class="mt-2" />
                </div>
                <div class="space-x-2 mt-4">
                  <PrimaryButton>Save</PrimaryButton>
                  <button @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
      <!-- table for list  -->
      <div class="w-full overflow-x-auto">
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-gray-300"> 
              <th class="px-4 py-2">Nome do Curso</th>
              <th class="px-4 py-2">Descrição</th>
              <th class="px-4 py-2">Preço</th>
              <th class="px-4 py-2">Data de Início</th>
              <th class="px-4 py-2">Data de Término</th>
              <th class="px-4 py-2">Max. de Alunos</th>
              <th class="px-4 py-2">Material</th>
            </tr>
          </thead>
          <tbody>
            <tr> 
              <td class="px-4 py-2">{{ course.course_name }}</td>
              <td class="px-4 py-2">{{ course.course_description }}</td>
              <td class="px-4 py-2">R$:{{ course.course_price }}</td>
              <td class="px-4 py-2">{{ course.start_date }}</td>
              <td class="px-4 py-2">{{ course.end_date }}</td>
              <td class="px-4 py-2">{{ course.max_students }}</td>
              <td class="px-4 py-2">
                  <template v-if="course.file_upload">
                      <a :href="'/downloads/' + course.file_upload" download class="text-blue-500 hover:underline">Baixar</a>
                  </template>
                  <template v-else>
                      <span class="text-gray-500">Sem Material</span>
                  </template>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

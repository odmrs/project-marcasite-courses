<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, InertiaLink, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps(['students']);

const form = useForm({
    // course_name: props.course.course_name,
    // course_description: props.course.course_description,
    // course_price: props.course.course_price,
    // start_date: props.course.start_date,
    // end_date: props.course.end_date,
    // max_students: props.course.max_students,
    // file_upload: props.course.file_upload,
    // remember: false
});

const editing = ref(false);
const deleting = ref(false);
</script>

<template>
  <Head title="Courses" />
    <AuthenticatedLayout>
  <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">   
        <div class="flex justify-center w-full" v-if="$page.props.auth.user.is_admin">
          <InertiaLink :href="route('students.create')" class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-blue-200 hover:text-black text-black underline">Criar novo estudante</InertiaLink>
        </div>
        <form v-if="editing" @submit.prevent="form.put(route('students.update', { student: students.id }), { onSuccess: () => editing = false })" enctype="multipart/form-data">
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
                  <PrimaryButton>Salvar</PrimaryButton>
                  <button @click="editing = false; form.reset(); form.clearErrors()">Cancelar</button>
                </div>
            </form>
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
    <div class="w-full max-w-full overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrito</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de inscrição</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
            <td class="px-6 py-4 whitespace-nowrap">
              <button class="text-indigo-600 hover:text-indigo-900" @click="editing = true">Editar</button>
              /
              <button class="text-red-600 hover:text-red-900 text-red-600 hover:bg-red-100 hover:text-red-900" @click.prevent="$inertia.delete(route('students.destroy', { student: student.id }))">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</AuthenticatedLayout>
</template>

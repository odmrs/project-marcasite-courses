<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, InertiaLink, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout_without_logo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {  Link,  usePage } from '@inertiajs/vue3';


const props = defineProps(['students', 'courses']);

const form = useForm({
    name: props.students.name,
    course_id: props.students.course_id,
    cpf: props.students.cpf,
    email: props.students.email,
    userType: props.students.userType,
    address: props.students.address,
    company_name: props.students.company_name,
    phone: props.students.phone,
    password: props.students.password,
    cellphone: props.students.cellphone,
    remember: false
});

const editing = ref(false);

let atual_student_id;

const getCourseById = (id) => {
    const current_course = props.courses.find(course => course.id === id);
    return current_course.course_price;
};

</script>

<template>
  <Head title="Courses" />
    <AuthenticatedLayout>
  <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">   
        <div class="flex justify-center w-full" v-if="$page.props.auth.user.is_admin">
          <InertiaLink :href="route('students.create')" class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-blue-200 hover:text-black text-black underline">Criar novo estudante</InertiaLink>
        </div>
        
        <form v-if="editing" @submit.prevent="form.put(route('students.update', atual_student_id), { onSuccess: () => editing = false })">
          <GuestLayout>
          <form @submit.prevent="submit" enctype="multipart/form-data">
          <div>
            <InputLabel for="name" value="Nome do aluno" />
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div>
                <InputLabel for="email" value="E-mail do aluno" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
        
            <div>
                <InputLabel for="password" value="Senha para o aluno" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
        
            <div>
            <InputLabel for="cpf" value="CPF do aluno" />
            <TextInput
                id="cpf"
                type="text"
                class="mt-1 block w-full"
                v-model="form.cpf"
                placeholder="formato: 999.999.999-99"
                required
            />
            <InputError class="mt-2" :message="form.errors.cpf" />
        </div>
        <div>
            <InputLabel for="address" value="Endereço" />
            <TextInput
                id="address"
                type="text"
                class="mt-1 block w-full"
                v-model="form.address"
                required
            />
            <InputError class="mt-2" :message="form.errors.address" />
        </div>
        <div>
            <InputLabel for="company_name" value="Empresa" />
            <TextInput
                id="company_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.company_name"
            />
            <InputError class="mt-2" :message="form.errors.company_name" />
        </div>
        <div>
            <InputLabel for="phone" value="Telefone" />
            <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                placeholder="Formato:(99)9999-9999)"
            />
            <InputError class="mt-2" :message="form.errors.phone" />
        </div>
        <div>
            <InputLabel for="cellphone" value="Celular" />
            <TextInput
                id="cellphone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.cellphone"
                placeholder="Formato: (99)99999-9999"
            />
            <InputError class="mt-2" :message="form.errors.cellphone" />
        </div>
        <div>
            <label for="userType">Estudante | Associado | Profssional</label>
            <select v-model="form.userType" id="userType" class="mt-1 block w-full" required>
                <option value="estudante">Estudante</option>
                <option value="profissional">Profissional</option>
                <option value="associado">Associado</option>
            </select>
            <InputError class="mt-2" :message="form.errors.userType" />
        </div>  

        <div>
            <label for="course_id">Curso:</label>
            <select v-model="form.course_id" id="course_id" class="mt-1 block w-full">
                <option value="">Selecione um curso</option>
                <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.course_name }}</option>
            </select>
         </div>

        </form>
                <div class="space-x-2 mt-4">
                  <PrimaryButton>Salvar</PrimaryButton>
                  <button @click="editing = false; form.reset(); form.clearErrors()">Cancelar</button>
                </div>
              </GuestLayout>
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
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">valor</th>
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
            <td class="px-6 py-4 whitespace-nowrap">R$:{{ getCourseById(student.course_id) }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <button class="text-indigo-600 hover:text-indigo-900" @click="editing = true; atual_student_id = student.id">Editar</button>
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, InertiaLink, useForm } from '@inertiajs/inertia-vue3';
import { ref, computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout_without_logo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {  Link,  usePage } from '@inertiajs/vue3';
import html2pdf from 'html2pdf.js';
import { defineProps } from 'vue';

const props = defineProps(['students', 'courses']);

// Transform webpage to PDF -> download
const downloadPDF = () => {
    const element = document.getElementById('to_pdf');
    const opt = {
        margin:       0,
        filename:     'lista-de-estudates.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
    };
    html2pdf().from(element).set(opt).save();
};

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

// Searching by name
const searchQuery = ref('');

//Searching by category
const selectedCategory = ref('');

const filteredStudents = computed(() => {
    let filtered = props.students;

    // Filtrar por nome do aluno
    if (searchQuery.value.trim() !== '') {
        filtered = filtered.filter(student => student.name.toLowerCase().includes(searchQuery.value.trim().toLowerCase()));
    }

    // Filtrar por categoria (userType)
    if (selectedCategory.value !== '') {
        filtered = filtered.filter(student => student.userType === selectedCategory.value);
    }

    return filtered;
});

// Getting  the action of editing click in student especify
const editing = ref(false);

// get id of student to put in route student.update
let atual_student_id;

// Filter by price of course's student
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
        
        <!-- Show edit students just for ADMIN  -->
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
                  placeholder="Formato: 9999-9999)"
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
      <div class="mb-4 flex justify-between w-full max-w-4xl">
        <input type="text" v-model="searchQuery" placeholder="Buscar" class="w-1/2 px-3 py-2 border rounded-md">
    <select v-model="selectedCategory" class="w-1/4 px-3 py-2 border rounded-md">
      <option value="">Todas as categorias</option>
      <option value="estudante">Estudante</option>
      <option value="profissional">Profissional</option>
      <option value="associado">Associado</option>
    </select>
      </div>
      <!-- Tabela -->
      
      <div class="w-full max-w-full overflow-x-auto">
        <div class="flex justify-between mb-4">
        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" @click="downloadPDF()">Baixar pdf</button>
        <button class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600" @click="exportToExcel()">Exportar para XLR</button>
      </div>
        <table class="min-w-full" id="to_pdf">
          <thead class="bg-gray-50">
            <tr v-for="student in filteredStudents" :key="student.id"></tr>
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
            <tr v-for="student in filteredStudents" :key="student.id">
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

<!-- Logic to export table to xls  -->
<script>
import * as XLSX from 'xlsx';

export default {
  methods: {
    getCourseById(id) {
      const current_course = this.courses.find(course => course.id === id);
      return current_course ? current_course.course_price : '';
    },
    formatDate(dateString) {
      if (!dateString) return ''; // Retorna uma string vazia se a data for nula ou indefinida
      const date = new Date(dateString);
      const options = { day: '2-digit', month: '2-digit', year: '2-digit' };
      return date.toLocaleDateString('pt-BR', options);
    },
    exportToExcel() {
      const customizedStudents = this.students.map(student => ({
        Nome: student.name,
        Email: student.email,
        Criado_no_dia: this.formatDate(student.created_at),
        Tipo_Usuario: student.userType,
        Cpf: student.cpf,
        Endereco: student.address,
        Status: student.status,
        Preco_do_Curso: this.getCourseById(student.course_id),
      }));

      // Crie uma nova planilha
      const ws = XLSX.utils.json_to_sheet(customizedStudents);

      // Crie um novo arquivo de workbook
      const wb = XLSX.utils.book_new();

      // Adicione a planilha ao workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Index');

      // Salve o arquivo
      XLSX.writeFile(wb, 'lista-de-alunos.xlsx');
    }
  },
  props: ['students', 'courses']
}
</script>
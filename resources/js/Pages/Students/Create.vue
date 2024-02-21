<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
// import { useForm, usePage } from '@inertiajs/inertia-vue3';a
import { ref } from 'vue';

const form = useForm({
    name: '',
    course_id: '',
    email: '',
    userType: '',
    address: '',
    company_name: '',
    phone: '',
    password: '',
    cellphone: '',
    remember: false
});


const submit = () => {
    form.post(route('students.store'), {
        onFinish: () => form.reset(),
    });
};

const { allcourses } = usePage().props;
</script>


<template>
    <GuestLayout>
        <Head title="Cadastro de estudantes" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div>
        <h1>Lista de Cursos</h1>
        <ul>
            <li v-for="course in allcourses" :key="course.id">
                {{ course.name }}
            </li>
            <li>teste</li>
            <li>tesss</li>
        </ul>
    </div>
        <div>
            <InputLabel for="course_name" value="Nome do aluno" />
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
            <InputLabel for="cpf" value="CPF do aluno" />
            <TextInput
                id="cpf"
                type="number"
                class="mt-1 block w-full"
                v-model="form.cpf"
                min="99999999999"
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
                type="number"
                class="mt-1 block w-full"
                v-model="form.phone"
                min=99999999
            />
            <InputError class="mt-2" :message="form.errors.phone" />
        </div>
        <div>
            <InputLabel for="cellphone" value="Celular" />
            <TextInput
                id="cellphone"
                type="number"
                class="mt-1 block w-full"
                v-model="form.s"
                min=99999999999
            />
            <InputError class="mt-2" :message="form.errors.cellphone" />
        </div>
        <div>
            <label for="userType">Estudante | Associado | Profssional</label>
            <select v-model="form.userType" id="userType" class="mt-1 block w-full">
                <option value="estudante">Estudante</option>
                <option value="profissional">Profissional</option>
                <option value="associado">Associado</option>
            </select>
            <InputError class="mt-2" :message="form.errors.userType" />
        </div>  

        <div>
        <label for="course_id">Curso:</label>
        <select v-model="form.course_id" id="course" class="mt-1 block w-full">
            <option value="">Selecione um curso</option>
            <option v-for="course in courses" :key="course.id" :value="course_name">{{ course.name }}</option>
        </select>
    </div>


        <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('courses.index')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Deseja voltar?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar curso
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

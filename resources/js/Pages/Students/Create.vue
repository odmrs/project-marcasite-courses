<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

defineProps(['courses']);

const form = useForm({
    name: '',
    course_id: '',
    cpf:'',
    email: '',
    userType: '',
    address: '',
    company_name: '',
    phone: '',
    password: '',
    cellphone: '',
    remember: false
});

// const handleSubmit = () => {
//     form.post(route('students.store'), {
//         onFinish: () => form.reset(),
//     });
// };

const submit = () => {
    form.post(route('students.store'), {
        onFinish: () => form.reset(),
    });
};
</script>


<template>
    <GuestLayout>
        <Head title="Cadastro de estudantes" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <form @submit.prevent="submit" enctype="multipart/form-data">            <div>
    </div>
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


        <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('students.index')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Deseja voltar?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar alunos
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

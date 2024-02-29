<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    student: Object,
});

const form = useForm({
    name: props.student.name || "",
    course_id: props.student.course_id || "",
    cpf: props.student.cpf || "",
    email: props.student.email || "",
    userType: props.student.userType || "",
    address: props.student.address || "",
    company_name: props.student.company_name || "",
    phone: props.student.phone || "",
    password: props.student.password || "",
    cellphone: props.student.cellphone || "",
    remember: false,
});

const submit = () => {
    form.put(route("students.update", props.student.id), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Cadastro de estudantes" />
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-500 mb-4">
                Edição de Alunos
            </h1>
        </div>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div></div>
            <div>
                <InputLabel for="name" value="Novo nome do aluno" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="email" value="Novo e-mail do aluno" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Nova senha para o aluno" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="cpf" value="Editar CPF do aluno" />
                <TextInput
                    id="cpf"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.cpf"
                    placeholder="formato: 999.999.999-99"
                />
                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <div>
                <InputLabel for="address" value="Novo Endereço" />
                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                />
                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="company_name" value="Editar Empresa" />
                <TextInput
                    id="company_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.company_name"
                />
                <InputError class="mt-2" :message="form.errors.company_name" />
            </div>

            <div>
                <InputLabel for="phone" value="Novo Telefone" />
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
                <InputLabel for="cellphone" value="Novo Celular" />
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
                <label for="userType"
                    >Estudante | Associado | Profssional</label
                >
                <select
                    v-model="form.userType"
                    id="userType"
                    class="mt-1 block w-full"
                >
                    <option value="estudante">Estudante</option>
                    <option value="profissional">Profissional</option>
                    <option value="associado">Associado</option>
                </select>
                <InputError class="mt-2" :message="form.errors.userType" />
            </div>

            <div>
                <label for="course_id">Curso:</label>
                <select
                    v-model="form.course_id"
                    id="course_id"
                    class="mt-1 block w-full"
                >
                    <option value="">Selecione um curso</option>
                    <option
                        v-for="course in courses"
                        :key="course.id"
                        :value="course.id"
                    >
                        {{ course.course_name }}
                    </option>
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('students.index')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Deseja voltar?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Atualizar aluno
                </PrimaryButton>
            </div>
        </form>
        <!-- end form  -->
    </GuestLayout>
</template>

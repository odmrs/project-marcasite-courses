<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const updateEndDateMin = () => {
    // Atualiza a data mínima para a data final como sendo a mesma que a data de início
    form.end_date = form.start_date;
};

const form = useForm({
    course_name: '',
    course_description: '',
    course_price: '',
    start_date: '',
    end_date: '',
    max_students: '',
    remember: false
});

const submit = () => {
    form.post(route('courses.create'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Cadastro de cursos" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <form @submit.prevent="submit">
        <div>
            <InputLabel for="course_name" value="Nome do curso" />
            <TextInput
                id="course_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.course_name"
                required
            />
            <InputError class="mt-2" :message="form.errors.course_name" />
        </div>

        <!-- Campo de texto para a descrição do curso -->
        <div>
            <InputLabel for="course_description" value="Descrição do curso" />
            <TextInput
                id="course_description"
                type="text"
                class="mt-1 block w-full"
                v-model="form.course_description"
                required
            />
            <InputError class="mt-2" :message="form.errors.course_description" />
        </div>

        <!-- Campo de texto para o preço do curso -->
        <div>
            <InputLabel for="course_price" value="Preço do curso" />
            <TextInput
                id="course_price"
                type="number"
                class="mt-1 block w-full"
                v-model="form.course_price"
                min="0"
                required
            />
            <InputError class="mt-2" :message="form.errors.course_price" />
        </div>

        <!-- Campo de data para a data de início do curso -->
        <div>
            <InputLabel for="start_date" value="Data de ínicio" />
            <input
                id="start_date"
                type="date"
                class="mt-1 block w-full"
                v-model="form.start_date"
                required
                @change="updateEndDateMin"
            />
            <InputError class="mt-2" :message="form.errors.start_date" />
        </div>

        <!-- Campo de data para a data final do curso -->
        <div>
            <InputLabel for="end_date" value="Data final" />
            <input
                id="end_date"
                type="date"
                class="mt-1 block w-full"
                v-model="form.end_date"
                required
                :min="form.start_date"
            />
            <InputError class="mt-2" :message="form.errors.end_date" />
        </div>

        <!-- Campo de número para a quantidade máxima de alunos -->
        <div>
            <InputLabel for="max_students" value="Quantidade maxima de alunos" />
            <TextInput
                id="max_students"
                type="number"
                class="mt-1 block w-full"
                v-model="form.max_students"
                min="5"
                required
            />
            <InputError class="mt-2" :message="form.errors.max_students" />
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

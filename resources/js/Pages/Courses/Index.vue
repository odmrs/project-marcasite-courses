<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Course from "@/Components/Course.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";

defineProps(["courses"]);
</script>

<template>
    <Head title="Courses" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listagem dos cursos
            </h2>
        </template>
        <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">
            <div
                class="flex justify-center w-full"
                v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
            >
                <InertiaLink
                    :href="route('courses.create')"
                    class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-blue-200 hover:text-black text-black underline"
                    >Criar Novo Curso</InertiaLink
                >
            </div>
            <div
                class="flex justify-center w-full"
                v-if="$page.props.auth.user && !$page.props.auth.user.is_admin"
            >
                <InertiaLink
                    :href="route('courses.all')"
                    class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-blue-200 hover:text-black text-black underline"
                    >Meus cursos</InertiaLink
                >
            </div>
            <Course
                v-for="course in courses"
                :key="course.id"
                :course="course"
            />
        </div>
    </AuthenticatedLayout>
</template>

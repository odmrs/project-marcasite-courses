<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Course from "@/Components/Course.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import { defineProps } from "vue";

// Define as propriedades
const props = defineProps({
    courses: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Courses" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meus Cursos
            </h2>
            <table class="min-w-full" id="to_pdf">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Nome do Curso</th>
                        <th class="px-4 py-2">Descrição</th>
                        <th class="px-4 py-2">Pendencia</th>
                        <th class="px-4 py-2">Data de Início</th>
                        <th class="px-4 py-2">Data de Término</th>
                        <th class="px-4 py-2">Max. de Alunos</th>
                        <th class="px-4 py-2">Material</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="course in courses" :key="course.id">
                        <td class="px-4 py-2 whitespace-nowrap">
                            {{ course.course_name }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            {{ course.course_description }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            R$:{{ course.course_price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{
                                course.start_date
                                    ? new Date(
                                          course.start_date
                                      ).toLocaleDateString("pt-BR")
                                    : ""
                            }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{
                                course.end_date
                                    ? new Date(
                                          course.end_date
                                      ).toLocaleDateString("pt-BR")
                                    : ""
                            }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            {{ course.max_students }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <template v-if="course.file_upload">
                                <a
                                    :href="'/downloads/' + course.file_upload"
                                    download
                                    class="text-blue-500 hover:underline"
                                    >Baixar</a
                                >
                            </template>
                            <template v-else>
                                <span class="text-gray-500">Sem Material</span>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
        <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8"></div>
    </AuthenticatedLayout>
</template>

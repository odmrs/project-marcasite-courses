<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import InputError from "@/Components/InputError.vue";

import PrimaryButton from "@/Components/PrimaryButton.vue";

import { ref } from "vue";

const props = defineProps(["course"]);

const editing = ref(false);
</script>
<template>
    <div class="container mx-auto p-6 flex flex-col items-center">
        <div class="w-full max-w-full">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <span class="text-gray-800">{{ course.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{
                        new Date(course.created_at).toLocaleString()
                    }}</small>
                    <small
                        v-if="course.created_at !== course.updated_at"
                        class="text-sm text-gray-600"
                    >
                        &middot; edited</small
                    >
                </div>
                <Dropdown
                    v-if="
                        $page.props.auth.user && $page.props.auth.user.is_admin
                    "
                >
                    <template #trigger>
                        <button>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                                />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <dropdown-link
                            as="button"
                            :href="route('courses.edit', course.id)"
                            method="get"
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                        >
                            Editar
                        </dropdown-link>
                        <DropdownLink
                            as="button"
                            :href="route('courses.destroy', course.id)"
                            method="delete"
                            class="text-red-600 hover:bg-red-100 hover:text-red-900"
                        >
                            Deletar
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
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
                                        :href="
                                            '/downloads/' + course.file_upload
                                        "
                                        download
                                        class="text-blue-500 hover:underline"
                                        >Baixar</a
                                    >
                                </template>
                                <template v-else>
                                    <span class="text-gray-500"
                                        >Sem Material</span
                                    >
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

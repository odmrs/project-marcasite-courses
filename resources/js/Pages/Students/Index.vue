<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, InertiaLink, useForm } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout_without_logo.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, usePage } from "@inertiajs/vue3";
import html2pdf from "html2pdf.js";
import { defineProps } from "vue";

const props = defineProps(["students", "courses"]);

// Transform webpage to PDF -> download
const downloadPDF = () => {
    const element = document.getElementById("to_pdf");
    const opt = {
        margin: 0,
        filename: "lista-de-estudates.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
    };
    html2pdf().from(element).set(opt).save();
};

// Searching by name
const searchQuery = ref("");

//Searching by category
const selectedCategory = ref("");

const filteredStudents = computed(() => {
    let filtered = props.students;

    // Filtrar por nome do aluno
    if (searchQuery.value.trim() !== "") {
        filtered = filtered.filter((student) =>
            student.name
                .toLowerCase()
                .includes(searchQuery.value.trim().toLowerCase())
        );
    }

    // Filtrar por categoria (userType)
    if (selectedCategory.value !== "") {
        filtered = filtered.filter(
            (student) => student.userType === selectedCategory.value
        );
    }

    return filtered;
});

// get id of student to put in route student.update
let atual_student_id;
</script>

<template>
    <Head title="Courses" />
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">
            <div
                class="flex justify-center w-full"
                v-if="$page.props.auth.user.is_admin"
            >
                <InertiaLink
                    :href="route('students.create')"
                    class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-blue-200 hover:text-black text-black underline"
                    >Criar novo estudante</InertiaLink
                >
            </div>
            <!-- Tabela -->

            <div class="w-full max-w-full overflow-x-auto">
                <div class="flex justify-between mb-4">
                    <button
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        @click="downloadPDF()"
                    >
                        Baixar pdf
                    </button>
                    <button
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                        @click="exportToExcel()"
                    >
                        Exportar para XLS
                    </button>
                </div>
                <table class="min-w-full" id="to_pdf">
                    <thead class="bg-gray-50">
                        <tr
                            v-for="student in filteredStudents"
                            :key="student.id"
                        ></tr>
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Inscrito
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Data de inscrição
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Categoria
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                CPF
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Address
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="student in filteredStudents"
                            :key="student.id"
                        >
                            <td
                                class="px-6 py-4 whitespace-nowrap"
                                @click="route"
                                style="cursor: pointer"
                            >
                                <InertiaLink
                                    :href="route('courses.all')"
                                    class="px-4 py-2 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-gray-100 hover:text-black text-black underline inline-block"
                                >
                                    {{ student.name }}</InertiaLink
                                >
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{
                                    student.created_at
                                        ? new Date(
                                              student.created_at
                                          ).toLocaleDateString("pt-BR")
                                        : ""
                                }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ student.userType }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ student.cpf }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ student.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ student.address }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ student.status }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    class="text-blue-600 hover:text-blue-900 text-blue-600 hover:bg-blue-100 hover:text-blue-900"
                                    @click.prevent="
                                        $inertia.visit(
                                            route('students.edit', {
                                                student: student.id,
                                            })
                                        )
                                    "
                                >
                                    Editar
                                </button>

                                /
                                <button
                                    class="text-red-600 hover:text-red-900 text-red-600 hover:bg-red-100 hover:text-red-900"
                                    @click.prevent="
                                        $inertia.delete(
                                            route('students.destroy', {
                                                student: student.id,
                                            })
                                        )
                                    "
                                >
                                    Excluir
                                </button>
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
import * as XLSX from "xlsx";

export default {
    methods: {
        formatDate(dateString) {
            if (!dateString) return ""; // Retorna uma string vazia se a data for nula ou indefinida
            const date = new Date(dateString);
            const options = {
                day: "2-digit",
                month: "2-digit",
                year: "2-digit",
            };
            return date.toLocaleDateString("pt-BR", options);
        },
        exportToExcel() {
            const customizedStudents = this.students.map((student) => ({
                Nome: student.name,
                Email: student.email,
                Criado_no_dia: this.formatDate(student.created_at),
                Tipo_Usuario: student.userType,
                Cpf: student.cpf,
                Endereco: student.address,
                Status: student.status,
            }));

            // Crie uma nova planilha
            const ws = XLSX.utils.json_to_sheet(customizedStudents);

            // Crie um novo arquivo de workbook
            const wb = XLSX.utils.book_new();

            // Adicione a planilha ao workbook
            XLSX.utils.book_append_sheet(wb, ws, "Index");

            // Salve o arquivo
            XLSX.writeFile(wb, "lista-de-alunos.xlsx");
        },
    },
    props: ["students", "courses"],
};
</script>

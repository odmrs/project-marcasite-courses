<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Course from '@/Components/Course.vue';
import { Head, InertiaLink } from '@inertiajs/inertia-vue3';

defineProps(['courses']);
</script>

<template>
  <Head title="Courses" />
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto p-8 sm:p-10 lg:p-8">   
      <div class="flex justify-center w-full">
        <InertiaLink :href="route('courses.create')" class="inline-block px-60 py-5 bg-blue-500 text-black font-semibold rounded-md transition duration-300 ease-in-out hover:bg-gray-300 hover:text-black text-blue-500 underline">Criar Novo Curso</InertiaLink>
      </div>

      <Course
        v-for="course in courses"
        :key="course.id"
        :course="course"
      />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
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

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <Head title="Iniciar sesión" />

  <div class="min-h-screen flex flex-col items-center justify-center bg-white-100">
    <!-- Logo -->
    <div class="mb-6">
      <img src="/images/logo.png" alt="Logo Escuela" class="h-40" />
    </div>

    <!-- Card -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
      <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h1>

      <!-- Errores -->
      <div v-if="form.errors.email" class="text-red-600 text-sm mb-2">{{ form.errors.email }}</div>
      <div v-if="form.errors.password" class="text-red-600 text-sm mb-2">{{ form.errors.password }}</div>

      <!-- Form -->
      <form @submit.prevent="submit" class="space-y-4">
        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
          <input id="email" type="email" v-model="form.email" required autofocus
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input id="password" type="password" v-model="form.password" required
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>


        <!-- Botón -->
        <button type="submit" :disabled="form.processing"
          class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
          Ingresar
        </button>
      </form>

    </div>
  </div>
</template>
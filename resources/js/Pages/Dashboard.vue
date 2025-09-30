<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Pestaña activa
const activeTab = ref("tickets");
</script>
<template>

    <Head title="Soporte TI" />

    <AuthenticatedLayout>
       

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Navegación de pestañas -->
                <div class="flex space-x-4 border-b mb-4">
                    <button @click="activeTab = 'tickets'"
                        :class="[activeTab === 'tickets' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600']"
                        class="pb-2 font-medium">
                        Tickets
                    </button>
                    <button @click="activeTab = 'estadisticas'"
                        :class="[activeTab === 'estadisticas' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600']"
                        class="pb-2 font-medium">
                        Estadisticas
                    </button>
                    <button @click="activeTab = 'crud'"
                        :class="[activeTab === 'crud' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600']"
                        class="pb-2 font-medium">
                        Base de datos
                    </button>
                </div>

                <!-- Contenido según la pestaña -->
                <div class="bg-white shadow rounded-lg p-6">
                    <!-- Pestaña Tickets -->
                    <div v-if="activeTab === 'tickets'">
                        
                    </div>

                    <!-- Pestaña Reportes -->
                    <div v-if="activeTab === 'reportes'">
                        <h3 class="text-lg font-semibold mb-4">Reportes de Tickets</h3>
                        <!-- Aquí van las gráficas -->
                        <p>📊 Aquí mostraremos gráficas de reportes...</p>
                    </div>

                    <!-- Pestaña CRUD -->
                    <div v-if="activeTab === 'crud'">
                        <h3 class="text-lg font-semibold mb-4">Administración del sistema</h3>
                        <ul class="list-disc pl-6">
                            <li>Áreas</li>
                            <li>Categorías</li>
                            <li>Usuarios</li>
                            <!-- cada uno puede abrir un CRUD -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

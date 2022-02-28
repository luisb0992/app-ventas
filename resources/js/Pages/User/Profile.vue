<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import Loading from "@/Components/custom/Loading.vue";
import Toast from "@/Components/custom/Toast.vue";

// utils
import {
    updateUser,
    loading,
    loadingPass,
    errorUpdateProfile,
    errorUpdatePass,
    toastMessage as toast,
} from "@/Pages/User/utils/updateProfile.js";
import { Head, useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const user = computed(() => usePage().props.value.auth.user);

const form = useForm({
    id: user.value.id,
    name: user.value.name,
    lastname: user.value.lastname,
    user: user.value.user,
    password: user.value.password,
});

</script>
<template>
    <BreezeAuthenticatedLayout>
        <Head title="Perfil" />

        <Toast
            @close-toast="toast.show = false"
            :message="toast.message"
            :bg="toast.bg"
            :show="toast.show"
        />

        <div class="w-full">
            <div class="animate-fade-in-down rounded-lg">
                <div class="lg:flex lg:justify-between">
                    <div
                        class="lg:w-[55%] px-5 py-5 mb-6 lg:mb-0 bg-white shadow-lg"
                    >
                        <!-- sub-header -->
                        <div class="lg:text-left mb-5">
                            <h2
                                class="text-blue-sales-1 font-semibold tracking-wide uppercase border-b-blue-sales-1 border-b-2 pb-3"
                            >
                                Perfil del usuario
                                <span class="text-gray-900 font-bold">
                                    {{ user.fullname }}
                                </span>
                            </h2>
                        </div>
                        <!-- /sub-header -->

                        <div class="block items-center justify-center">
                            <BreezeValidationErrors
                                class="mb-4 bg-gray-50 border border-gray-200 rounded-lg py-6 pl-4"
                                v-show="errorUpdateProfile"
                            />
                            <form @submit.prevent="updateUser('profile', form)">
                                <div class="relative z-0 mb-6 w-full group">
                                    <input
                                        type="text"
                                        name="name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" "
                                        required=""
                                        v-model="form.name"
                                    />
                                    <label
                                        for="name"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    >
                                        Nombre
                                    </label>
                                </div>
                                <div class="relative z-0 mb-6 w-full group">
                                    <input
                                        type="text"
                                        name="lastname"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" "
                                        required=""
                                        v-model="form.lastname"
                                    />
                                    <label
                                        for="lastname"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    >
                                        Apellido
                                    </label>
                                </div>
                                <div class="relative z-0 mb-6 w-full group">
                                    <input
                                        type="text"
                                        name="user"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" "
                                        required=""
                                        v-model="form.user"
                                    />
                                    <label
                                        for="user"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    >
                                        Nombre de usuario
                                    </label>
                                </div>
                                <div
                                    class="lg:inline-flex lg:justify-start lg:items-center"
                                >
                                    <button
                                        :disabled="loading"
                                        :class="
                                            loading
                                                ? 'opacity-50 cursor-not-allowed'
                                                : ''
                                        "
                                        type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    >
                                        Actualizar
                                    </button>
                                    <Loading
                                        width="w-4"
                                        height="h-4"
                                        class="lg:-mt-12 hidden lg:inline-block"
                                        v-show="loading"
                                    />
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="lg:w-[40%] px-5 py-5 bg-white shadow-lg">
                        <!-- sub-header -->
                        <div class="lg:text-left mb-5">
                            <h2
                                class="text-blue-sales-1 font-semibold tracking-wide uppercase border-b-blue-sales-1 border-b-2 pb-3"
                            >
                                Cambio de clave
                            </h2>
                        </div>
                        <!-- /sub-header -->

                        <div class="block items-center justify-center">
                            <BreezeValidationErrors
                                class="mb-4 bg-gray-50 border border-gray-200 rounded-lg py-6 pl-4"
                                v-show="errorUpdatePass"
                            />
                            <form @submit.prevent="updateUser('pass', form)">
                                <div class="relative z-0 mb-6 w-full group">
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" "
                                        required=""
                                        v-model="form.password"
                                    />
                                    <label
                                        for="password"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    >
                                        Clave
                                    </label>
                                </div>
                                <div
                                    class="lg:inline-flex lg:justify-start lg:items-center mt-32"
                                >
                                    <button
                                        :disabled="loadingPass"
                                        :class="
                                            loadingPass
                                                ? 'opacity-50 cursor-not-allowed'
                                                : ''
                                        "
                                        type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center lg:items-end lg:flex"
                                    >
                                        Actualizar
                                    </button>
                                    <Loading
                                        width="w-4"
                                        height="h-4"
                                        class="lg:-mt-12 hidden lg:inline-block"
                                        v-show="loadingPass"
                                    />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

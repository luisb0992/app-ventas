<script setup>
// componentes
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import Loading from "@/Components/custom/Loading.vue";

// libs
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
    appName: String,
});

const form = useForm({
    user: "",
    password: "",
    remember: false,
});

const loading = ref(false);

const submit = () => {
    loading.value = true;
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
            loading.value = false;
        },
        onError: () => {
            loading.value = false;
            setTimeout(() => {
                usePage().props.value.errors = {};
            }, 3000);
        },
    });
};
</script>

<template>
    <BreezeGuestLayout :appName="appName">
        <Head title="Ingresar" />

        <BreezeValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <Loading v-if="loading" />

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="user" value="Usuario" />
                <BreezeInput
                    id="user"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.user"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox
                        name="remember"
                        v-model:checked="form.remember"
                    />
                    <span class="ml-2 text-sm text-gray-600">Recordar</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <!-- <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link> -->

                <BreezeButton
                    class=""
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Ingresar
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>

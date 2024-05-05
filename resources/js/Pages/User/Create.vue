<template>
    <Head title="Create User"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create User</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <Card>
                    <template #content>
                        <Form :form="form" :submit="submit" :roles="props.roles"/>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {useForm} from "@/hooks/useForm";
import Card from "@/Components/Card.vue";
import {UserForm} from "@/Models/User";
import Form from "./Form.vue";

interface Props {
    roles: string[];
}

const props = defineProps<Props>();

const {form, submit} = useForm<UserForm>({
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: "user"
    },
    route("users.store"),
    "post"
);

</script>

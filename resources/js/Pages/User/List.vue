<template>
    <Head title="Users"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>

                <div class="px-3">
                    <PrimaryButton :href="route('users.create')">
                        Create User
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <Card>
                    <template #content>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    First Name
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Name
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roles
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in users.data">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ user.first_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ user.last_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ user.email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" v-for="(role, roleIndex) in user.roles"
                                         :key="roleIndex">{{ role.name }}
                                    </div>
                                </td>
                                <td class="flex justify-end px-6 py-4 gap-2 whitespace-nowrap text-right text-sm font-medium">
                                    <PrimaryButton
                                        :as="Link"
                                        :href="route('users.edit', user.uuid)"
                                    >
                                        Edit
                                    </PrimaryButton>

                                    <SecondaryButton
                                        :as="Link"
                                        :href="route('users.show', user.uuid)"
                                    >
                                        Show
                                    </SecondaryButton>

                                    <DangerButton @click="confirmUserDeletion(user)">
                                        Delete
                                    </DangerButton>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                </Card>
            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once this account is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

import {PaginatedCollection} from "@/types/pagination";
import {User} from "@/Models/User";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import {ref, defineProps} from "vue";
import Modal from "@/Components/Modal.vue";

interface Props {
    users: PaginatedCollection<User>;
}

const props = defineProps<Props>();
const confirmingUserDeletion = ref(false);
const userDeleting = ref(null as User | null);
const confirmUserDeletion = (user: User) => {
    confirmingUserDeletion.value = true;
    userDeleting.value = user;
};
const form = useForm({});
const deleteUser = () => {
    form.delete(route('users.destroy', [userDeleting.value]), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    userDeleting.value = null;

    form.reset();
};

</script>

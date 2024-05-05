<template>
    <div class="space-y-4">
        <div>
            <InputLabel for="first_name" value="First Name" />

            <TextInput
                id="first_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.first_name"
                required
                autofocus
                autocomplete="first_name"
            />

            <InputError class="mt-2" :message="form.errors.first_name" />
        </div>

        <div>
            <InputLabel for="last_name" value="Last Name" />

            <TextInput
                id="last_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.last_name"
                required
                autofocus
                autocomplete="last_name"
            />

            <InputError class="mt-2" :message="form.errors.last_name" />
        </div>

        <div>
            <InputLabel for="email" value="E-mail" />

            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autofocus
                autocomplete="email"
            />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div>
            <InputLabel for="password" value="Password" />

            <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autofocus
                autocomplete="password"
            />

            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div>
            <InputLabel for="password_confirmation" value="Password Confirmation" />

            <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autofocus
                autocomplete="password_confirmation"
            />

            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div>
            <InputLabel for="role" value="Role" />

            <SelectInput
                id="role"
                class="mt-1 block w-full"
                v-model="form.role"
                :options="roles"
                required
            />

            <InputError class="mt-2" :message="form.errors.role" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton @click="submit" :disabled="form.processing">Save</PrimaryButton>

            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
            </Transition>
        </div>
    </div>
</template>

<script setup lang="ts">
import {defineProps} from "vue";
import {InertiaForm} from "@inertiajs/vue3";
import type {UserForm} from "@/Models/User";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

interface Props {
    form: InertiaForm<UserForm>;
    submit: void;
    roles: string[];
}

const props = defineProps<Props>();
</script>

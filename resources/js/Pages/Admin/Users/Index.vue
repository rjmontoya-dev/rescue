<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import { Head,Link, useForm ,usePage} from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {computed,ref,onMounted} from "vue";
import SectionBorder from '@/Components/SectionBorder.vue';
import DataTable from '@/Components/Common/Table/DataTable.vue';
import { useCrud } from '@/Composable/crud';
import {convertTo} from '@/Composable/convertable';
const users = computed(() => usePage().props.users)
const user_data = users.data;
const {submitForm,destroy} = useCrud();
const {dateConverter} = convertTo();
const tableHeader = [
    {label: "Name", field:'name'},
    {label: "Email", field:'email'},
    {label: "Date", field:'created_at'},
    {label: 'Actions', field: 'action'},
]
const form = useForm({
    id:null,
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});
const isUpdate = ref(false);
const editData = (data) => {
    isUpdate.value = true;
    form.id = data.id;
    form.name = data.name;
    form.email = data.email;
}
const submit = async () => {
    if(isUpdate.value){
     await submitForm(form, "admin.users.update-user")
        .then((result) => {
            cancel();
        })
    }else{
        await submitForm(form, "admin.users.register-user")
        .then((result) => {
            emit('on-success')
        })
    }
}
const destroyData=(id)=>{
    destroy(route('admin.users.destroy-user', id));
}

</script>
<template>
    <Head title="Register" />
    <AppLayout title="Regiser">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Management
            </h2>
        </template>
        <div class=" rounded-lg p-4 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  ">
                <div class="md:grid md:grid-cols-3 md:gap-6 mb-4">
                    <SectionTitle>
                        <template #title>
                        Register User
                        </template>
                        <template #description>
                        Users can also be register by admin.
                        </template>
                    </SectionTitle>
                    <div class="col-span-2">
                        <div class=" bg-white shadow mt-4 rounded-lg md:mt-0 md:col-span-2 p-4 ">
                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Register</h3>
                                <form @submit.prevent="submit">
                                    <div>
                                        <InputLabel for="name" value="Name" />
                                        <TextInput
                                            id="name"
                                            v-model="form.name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                            autofocus
                                            autocomplete="name"
                                        />
                                        <InputError class="mt-2" :message="form.errors.name" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="email" value="Email" />
                                        <TextInput
                                            id="email"
                                            v-model="form.email"
                                            type="email"
                                            class="mt-1 block w-full"
                                            required
                                            autocomplete="username"
                                        />
                                        <InputError class="mt-2" :message="form.errors.email" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="password" value="Password" />
                                        <TextInput
                                            id="password"
                                            v-model="form.password"
                                            type="password"
                                            class="mt-1 block w-full"
                                            required
                                            autocomplete="new-password"
                                        />
                                        <InputError class="mt-2" :message="form.errors.password" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="password_confirmation" value="Confirm Password" />
                                        <TextInput
                                            id="password_confirmation"
                                            v-model="form.password_confirmation"
                                            type="password"
                                            class="mt-1 block w-full"
                                            required
                                            autocomplete="new-password"
                                        />
                                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                                    </div>

                                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                                        <InputLabel for="terms">
                                            <div class="flex items-center">
                                                <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                                                <div class="ms-2">
                                                    I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                                                </div>
                                            </div>
                                            <InputError class="mt-2" :message="form.errors.terms" />
                                        </InputLabel>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Register
                                        </PrimaryButton>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <SectionBorder/>
        <div class=" rounded-lg p-4 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class="md:grid md:grid-cols-3 md:gap-6 mb-4">
                   <SectionTitle class="mb-4">
                        <template #title>
                        User Lists
                        </template>
                        <template #description>
                        Verified and Registered users.
                        </template>
                    </SectionTitle>
                    <div class="col-span-2">
                        <div class=" bg-white shadow   rounded-lg md:mt-0 md:col-span-2 p-4 mb-8">
                            <div class="relative overflow-x-auto">
                                <DataTable :columns="tableHeader" :data="users">
                                    <template #column_created_at="{props}">
                                        <p class="text-sm">
                                            {{dateConverter(props.created_at)}}
                                        </p>
                                    </template>
                                     <template #column_action="{props}">
                                        <div class="flex justify-center items-center">
                                             <button @click="destroyData(props.id)">
                                                    <i class="bi bi-trash text-red-500"></i>
                                            </button>
                                        </div>
                                    </template>
                                </DataTable>

                                <!-- <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">
                                                #
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                NAME
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                EMAIL
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                DATE
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in users" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{index+1}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{item.name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{item.email}}
                                            </td>
                                             <td class="px-6 py-4">
                                                {{item.created_at}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <button @click="destroyData(item.id)">
                                                    <i class="bi bi-trash text-red-500"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

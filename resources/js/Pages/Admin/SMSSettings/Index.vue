<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import TextInput from "@/Components/TextInput.vue";
import SectionBorder from '@/Components/SectionBorder.vue';
import {computed,ref,onMounted} from "vue";
import {useForm, usePage,router} from "@inertiajs/vue3";
import { useCrud } from '@/Composable/crud';


const contacts = computed(() => usePage().props.contacts)
const _messagecontent = computed(() =>usePage().props.messagecontent);

const contact_information_form = useForm({id:null,name:null,phone_number:null,details:null});
const message_form = useForm({id:null,category:null,body:null});

const {submitForm,destroy} = useCrud();

const isUpdate = ref(false);

const cancel = ()=>{
    isUpdate.value = false;
    router.get('index');
}
const reset = ()=>{
    contact_information_form.name = "";
    contact_information_form.phone_number = "";
    contact_information_form.details = "";
}
const editData = (data) => {
    isUpdate.value = true;
    contact_information_form.id = data.id;
    contact_information_form.name = data.name;
    contact_information_form.phone_number = data.phone_number;
    contact_information_form.details = data.details;
}
const submit = async () => {
    if(isUpdate.value){
     await submitForm(contact_information_form, "admin.settings.contact.update")
        .then((result) => {
            cancel();
        })
    }else{
        await submitForm(contact_information_form, "admin.settings.contact.store")
        .then((result) => {
            emit('on-success')
            reset();
        })
    }
}
const updateMessageContent = async () => {
    await submitForm(message_form, "admin.settings.updateContent")
    .then((result) => {
        reset();
    })
}
const destroyData=(id)=>{
    destroy(route('admin.settings.contact.destroy', id));
}
const getCategory=(category)=>{
    Object.values(_messagecontent.value).map((item) => {
        if(category == item.category){
                message_form.category = item.category;
                message_form.id = item.id;
            return  message_form.body = item.body;
        }
    });
}
</script>
<template>
    <AppLayout title="SMS Settings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Setting Management
            </h2>
        </template>
        <div class=" rounded-lg p-4 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  ">
                <div class="md:grid md:grid-cols-3 md:gap-6 mb-4">
                    <SectionTitle>
                        <template #title>
                        Message Content
                        </template>
                        <template #description>
                        A text message that will be displayed in the recipients phone inbox.
                        </template>
                    </SectionTitle>
                    <div class="col-span-2">
                        <div class=" bg-white shadow mt-4 rounded-lg md:mt-0 md:col-span-2 p-4 ">
                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Water Level Categories</h3>
                            <form @submit.prevent=updateMessageContent>
                                <ul class="mb-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex  ">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input checked @click="getCategory('lvl1')" id="horizontal-list-radio-license" type="radio" value="lvl1" name="list-radio" class=" w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-license" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Level 1 <span class="text-green-500">(Alert)</span></label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input @click="getCategory('lvl2')" id="horizontal-list-radio-id" type="radio" value="lvl2" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-id" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Level 2 <span class="text-orange-500">(Preparation)</span></label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input @click="getCategory('lvl3')" id="horizontal-list-radio-millitary" type="radio" value="lvl3" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-millitary" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Level 3 <span class="text-red-500">(Evacuation)</span></label>
                                        </div>
                                    </li>
                                </ul>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message Context</label>
                                <textarea v-model="message_form.body" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..."></textarea>
                                <div class="md:w-full md:flex justify-end mt-4 md:mb-4 md:mt-4 ">
                                    <PrimaryButton @click="updateMessageContent" class="w-full  md:w-auto  md:mt-0 lg:mt-2 ">Update</PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <SectionBorder/>
        <div class=" rounded-lg p-4 mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class="md:grid md:grid-cols-3 md:gap-6  ">
                    <SectionTitle>
                        <template #title>
                        Contact Information
                        </template>
                        <template #description>
                        Information  about a flood alert in the area.
                        </template>
                    </SectionTitle>
                    <div class="col-span-2">
                        <div class=" bg-white shadow mt-4 rounded-lg md:mt-0 md:col-span-2 p-4 mb-2">
                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Add Contact Person</h3>
                            <div class="">
                                <form @submit.prevent="submit" class="md:flex md:flex-wrap ">
                                    <TextInput class="mb-2    w-full  "
                                        id="name"
                                        placeholder="Enter Name"
                                        v-model="contact_information_form.name"
                                        :error="contact_information_form.errors['name']"
                                        required
                                        @update:model-value="contact_information_form.clearErrors('name')"
                                    />
                                    <TextInput class="mb-2 w-full"
                                        type="number"
                                        id="phone_number"
                                        placeholder="Enter number"
                                        v-model="contact_information_form.phone_number"
                                        :error="contact_information_form.errors['phone_number']"
                                        required
                                        @update:model-value="contact_information_form.clearErrors('phone_number')"
                                    />
                                    <TextInput class="w-full"
                                        type="text"
                                        id="details"
                                        placeholder="Enter Person Detail"
                                        v-model="contact_information_form.details"
                                        :error="contact_information_form.errors['details']"
                                        required
                                        @update:model-value="contact_information_form.clearErrors('details')"
                                    />
                                    <div class="md:w-full md:flex justify-end mt-4 md:mb-4 md:mt-4 ">
                                        <SecondaryButton @click="cancel" class="w-full  md:w-auto  mt-2">Cancel</SecondaryButton>
                                        <PrimaryButton @click="submit" class="w-full  md:w-auto  md:ml-4  mt-2">{{isUpdate ? 'Update Action' : 'Add Action'}}</PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" rounded-lg p-4 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class="md:grid md:grid-cols-3 md:gap-6 mb-4">
                    <SectionTitle>
                    </SectionTitle>
                    <div class="col-span-2">
                        <div class=" bg-white shadow   rounded-lg md:mt-0 md:col-span-2 p-4 mb-8">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">
                                            #
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                NAME
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                PHONE NUMBER
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               DETAIL
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in contacts" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{index+1}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{item.name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{item.phone_number}}
                                            </td>
                                             <td class="px-6 py-4">
                                                {{item.details}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <button @click="editData(item)">
                                                    <i class="bi bi-pencil-square text-blue-500"></i>
                                                </button>
                                                <button @click="destroyData(item.id)">
                                                    <i class="bi bi-trash text-red-500"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

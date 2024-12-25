<template>
    <div class="max-w-7xl mx-auto py-12">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-around">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Профіль користувача</h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <form @submit.prevent="logout">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                            Вийти з аккаунту
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:px-6">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:text-center sm:flex-1">
                            <nav class="space-x-4 flex justify-center">
                                <button
                                    :class="['px-3 py-2 font-medium text-lg rounded-md', activeTab === 'info' ? 'text-blue-600' : 'text-gray-500']"
                                    @click="activeTab = 'info'"
                                >
                                    Інформація
                                </button>
                                <button
                                    :class="['px-3 py-2 font-medium text-lg rounded-md', activeTab === 'edit' ? 'text-blue-600' : 'text-gray-500']"
                                    @click="activeTab = 'edit'"
                                >
                                    Редагувати інформацію
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>

                <div v-if="activeTab === 'info'">
                    <dl class="space-y-8">
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-500">Ім'я</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:col-span-2 sm:mt-0">{{ user.name }}</dd>
                        </div>

                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:col-span-2 sm:mt-0">{{ user.email }}</dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-500">Телефон</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:col-span-2 sm:mt-0">{{ user.phone }}</dd>
                        </div>

                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-500">Дата створення акаунту</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:col-span-2 sm:mt-0">{{ formatDate(user.created_at) }}</dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-500">Останнє оновлення</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:col-span-2 sm:mt-0"> {{ formatDate(user.updated_at) }}</dd>
                        </div>
                    </dl>
                </div>

                <div v-if="activeTab === 'edit'" class="bg-white px-4 py-5 sm:px-6">
                    <form @submit.prevent="submitForm">
                        <div class="space-y-6">

                            <!-- Name input -->
                            <InputWithIcon
                                v-model="form.name"
                                id="name"
                                name="name"
                                type="text"
                                placeholder="Your name"
                                :error="errors.name"
                            >
                                <template #icon>
                                    <i class="ri-user-3-fill"></i>
                                </template>
                            </InputWithIcon>

                            <!-- Phone input -->
                            <PhoneInput :error="errors.phone" v-model="form.phone">
                                <template #icon>
                                    <i class="ri-phone-line"></i>
                                </template>
                            </PhoneInput>

                            <!-- Email input -->
                            <InputWithIcon
                                v-model="form.email"
                                id="email"
                                name="email"
                                type="email"
                                placeholder="name@domain.com"
                                :error="errors.email"
                            >
                                <template #icon>
                                    <i class="ri-mail-line"></i>
                                </template>
                            </InputWithIcon>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                                    Зберегти зміни
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import InputWithIcon from "@/Components/Forms/InputWithIcon.vue";
import PhoneInput from "@/Components/Forms/PhoneInput.vue";
import {Link} from "@inertiajs/vue3";

export default {
    components: {PhoneInput, InputWithIcon,Link},
    props: {
        user: Object,
        errors: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            activeTab: 'info',
            form: {
                name: this.user.name,
                email: this.user.email,
                phone: this.user.phone,
            }
        };
    },
    methods: {
        submitForm() {
            Inertia.post('/user/update', this.form);
        },
        logout() {
            Inertia.post(route('logout'));
        },
        formatDate(date) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            const formattedDate = new Date(date).toLocaleDateString('uk-UA', options); // Используем локаль "uk-UA"
            return formattedDate;
        },
    }
};
</script>

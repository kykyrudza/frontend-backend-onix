<template>
    <section class="py-12 h-full">
        <div class="tabs mb-6">
            <div class="flex">
                <ul class="flex bg-gray-100 rounded-2xl p-2 overflow-hidden">
                    <li>
                        <a
                            href="javascript:void(0)"
                            @click="activeTab = 'pickup'"
                            :class="['inline-block py-3 px-6 font-medium', activeTab === 'pickup' ? 'bg-white rounded-xl text-indigo-600' : 'text-gray-500 hover:text-gray-800']"
                        >
                            Самовивіз
                        </a>
                    </li>
                    <li>
                        <a
                            href="javascript:void(0)"
                            @click="activeTab = 'delivery'"
                            :class="['inline-block py-3 px-6 font-medium', activeTab === 'delivery' ? 'bg-white rounded-xl text-indigo-600' : 'text-gray-500 hover:text-gray-800']"
                        >
                            Доставка додому
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <form @submit.prevent="submitForm">
            <div v-if="activeTab === 'pickup'" class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Самовивіз (Самовивіз, лише по місту Кропивницький)
                </h3>
                <SelectInput
                    v-model="form.city"
                    :options="cities"
                    :error="errors.city"
                    placeholder="Місто"
                    name="city_select"
                    id="city_select"
                />
                <SelectInput
                    v-model="form.region"
                    :options="regions"
                    :error="errors.regions"
                    placeholder="Район"
                    name="region_select"
                    id="region_select"
                />
                <SelectInput
                    v-model="form.postOffices"
                    :options="postOffices"
                    :error="errors.postOffices"
                    placeholder="Відділення пошти"
                    name="postOffices"
                    id="postOffices"
                />
                <InputWithIcon
                    v-model="form.date"
                    :error="errors.date"
                    type="date"
                    placeholder="Дата самовивезення"
                    name="date"
                    id="date"
                >
                    <template #icon>
                        <i class="ri-calendar-line"></i>
                    </template>
                </InputWithIcon>
                <Textarea
                    v-model="form.comments"
                    :error="errors.comments"
                    placeholder="Коментар до самовивезення"
                />
            </div>

            <div v-if="activeTab === 'delivery'" class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Доставка додому
                </h3>
                <InputWithIcon
                    v-model="form.region"
                    :error="errors.region"
                    placeholder="Регіон / Область"
                    type="region"
                    name="region"
                    id="region"
                >
                    <template #icon>
                        <i class="ri-map-pin-line"></i>
                    </template>
                </InputWithIcon>
                <InputWithIcon
                    v-model="form.city"
                    :error="errors.city"
                    placeholder="Місто"
                    type="city"
                    name="city"
                    id="city"
                >
                    <template #icon>
                        <i class="ri-building-line"></i>
                    </template>
                </InputWithIcon>
                <InputWithIcon
                    v-model="form.street"
                    :error="errors.street"
                    placeholder="Вулиця"
                    type="street"
                    name="street"
                    id="street"
                >
                    <template #icon>
                        <i class="ri-road-map-line"></i>
                    </template>
                </InputWithIcon>
                <InputWithIcon
                    v-model="form.house"
                    :error="errors.house"
                    placeholder="Дім / Квартира"
                    type="house"
                    name="house"
                    id="house"
                >
                    <template #icon>
                        <i class="ri-home-4-line"></i>
                    </template>
                </InputWithIcon>
                <InputWithIcon
                    v-model="form.postal_code"
                    :error="errors.postal_code"
                    placeholder="Поштовий індекс"
                    type="postal_code"
                    name="post_index"
                    id="post_index"
                >
                    <template #icon>
                        <i class="ri-mail-open-line"></i>
                    </template>
                </InputWithIcon>
                <Textarea
                    v-model="form.comments"
                    :error="errors.comments"
                    placeholder="Коментар для кур'єра"
                />
            </div>

            <BasicButton type="submit" text="Наступний крок" />
        </form>
    </section>
</template>

<script>
import InputWithIcon from "@/Components/Forms/InputWithIcon.vue"
import PhoneInput from "@/Components/Forms/PhoneInput.vue"
import Textarea from "@/Components/Forms/Textarea.vue"
import SelectInput from "@/Components/Forms/SelectInput.vue"
import BasicButton from "@/Components/Forms/BasicButton.vue"
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "AddAddress",
    components: { InputWithIcon, PhoneInput, Textarea, SelectInput, BasicButton },
    props: {
        cities: {
            type: Object,
            required: true
        },
        regions: {
            type: Object,
            required: true
        },
        postOffices: {
            type: Object,
            required: true
        },
        token: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            activeTab: 'pickup',
            form: {
                postOffices: '',
                date: '',
                comments: '',
                country: '',
                street: '',
                house: '',
                postal_code: '',
            },
            errors: {},
        }
    },
    methods: {
        submitForm() {
            let formData = {};

            if (this.activeTab === 'pickup') {
                formData = {
                    activeTab: 'pickup',
                    city: this.form.city,
                    region: this.form.region,
                    postOffices: this.form.postOffices,
                    date: this.form.date,
                    comments: this.form.comments
                };
            } else if (this.activeTab === 'delivery') {
                formData = {
                    activeTab: 'delivery',
                    region: this.form.region,
                    city: this.form.city,
                    street: this.form.street,
                    house: this.form.house,
                    postal_code: this.form.postal_code,
                    comments: this.form.comments
                };
            }

            Inertia.post(route('order.store.addAddress', this.token), formData, {
                onStart: () => {
                    console.log('Отправка началась...');
                },
                onSuccess: () => {
                    console.log('Данные успешно отправлены!');
                },
                onError: (errors) => {
                    console.error('Ошибка при отправке:', errors);
                    this.errors = errors;
                },
                onFinish: () => {
                    console.log('Отправка завершена.');
                }
            });
        }
    }

}
</script>

<style scoped>
.tabs ul {
    display: flex;
    background-color: #f3f4f6;
    border-radius: 1rem;
}

.tabs ul li a {
    padding: 0.75rem 1.5rem;
    display: inline-block;
    font-weight: 500;
    transition: all 0.3s;
}

.tabs ul li a.bg-white {
    background-color: #ffffff;
    color: #4f46e5;
    border-radius: 1rem;
}

.tabs ul li a:hover {
    color: #4f46e5;
}
</style>

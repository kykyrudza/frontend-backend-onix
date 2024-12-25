<template>
    <div class="h-screen flex items-center justify-center">
        <div class="bg-white w-[35rem] rounded-lg shadow-2xl">
            <form @submit.prevent="handleForm" class="p-10">
                <Headline text="Введіть новий пароль" />
                <Headline class="text-xl !text-left" text="Введіть новий пароль та підтвердьте його, щоб завершити процес скидання." />

                <input type="hidden" v-model="form.email" />

                <InputWithIcon
                    v-model="form.password"
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Новий пароль"
                    :error="errors.password"
                >
                    <template #icon>
                        <i class="ri-lock-line"></i>
                    </template>
                </InputWithIcon>

                <InputWithIcon
                    v-model="form.password_confirmation"
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="Підтвердження пароля"
                    :error="errors.password_confirmation"
                >
                    <template #icon>
                        <i class="ri-lock-line"></i>
                    </template>
                </InputWithIcon>

                <input type="hidden" v-model="form.token" />

                <div class="flex mt-7 mb-5">
                    <BasicButton text="Скинути пароль" type="submit"/>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import InputWithIcon from "../../../Components/Forms/InputWithIcon.vue";
import Headline from "../../../Components/Forms/Headline.vue";
import BasicButton from "../../../Components/Forms/BasicButton.vue";
import FormLayout from "@/Layouts/FormLayout.vue";

export default {
    components: {
        InputWithIcon,
        Headline,
        BasicButton,
        FormLayout
    },
    layout: FormLayout,
    props: {
        errors: {
            type: Object,
            default: () => ({})
        },
        token: {
            type: String,
            required: true
        },
        email: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                email: this.email,
                password: '',
                password_confirmation: '',
                token: this.token
            })
        };
    },
    methods: {
        handleForm() {
            this.form.post(route('password.update'), {
                preserveState: true,
                preserveScroll: true
            });
        }
    }
};
</script>

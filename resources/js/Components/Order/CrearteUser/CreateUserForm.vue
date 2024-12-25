<template>
    <section class="py-12">
        <form @submit.prevent="send()">
            <Headline text="Заповніть форму, та натисніть 'Наступний крок'" />
            <InputWithIcon :error="errors.name" type="name" placeholder="Ведіть своє Ім'я" name="name" id="name" v-model="form.name">
                <template #icon>
                    <i class="ri-user-line"></i>
                </template>
            </InputWithIcon>
            <PhoneInput :error="errors.phone" v-model="form.phone">
                <template #icon>
                    <i class="ri-phone-line"></i>
                </template>
            </PhoneInput>
            <InputWithIcon :error="errors.email" type="email" placeholder="Ведіть свою пошту" name="email" id="email" v-model="form.email">
                <template #icon>
                    <i class="ri-mail-line"></i>
                </template>
            </InputWithIcon>
            <InputWithIcon :error="errors.password" type="password" placeholder="Ведіть пароль" name="password" id="password" v-model="form.password">
                <template #icon>
                    <i class="ri-lock-2-line"></i>
                </template>
            </InputWithIcon>
            <InputWithIcon :error="errors.password_confirmation" type="password" placeholder="Підтвердіть свій пароль" name="password_confirmation" id="password_confirmation" v-model="form.password_confirmation">
                <template #icon>
                    <i class="ri-lock-2-line"></i>
                </template>
            </InputWithIcon>
            <BasicButton type="submit" text="Наступний крок" />
        </form>
    </section>
</template>

<script>
import PhoneInput from "@/Components/Forms/PhoneInput.vue";
import {useForm} from "@inertiajs/vue3";
import InputWithIcon from "@/Components/Forms/InputWithIcon.vue";
import Headline from "@/Components/Forms/Headline.vue";
import BasicButton from "@/Components/Forms/BasicButton.vue";

export default {
    name: "CreateUserForm",
    components: {BasicButton, Headline, InputWithIcon, PhoneInput},
    props:{
        token: {
            type: String,
            required: true
        },
        errors: {
            type: Object,
            default: () => ({})
        }
    },
    setup() {
        const form = useForm({
            name: '',
            phone: '',
            email: '',
            password: '',
            password_confirmation: '',
        });

        return { form };
    },
    methods: {
        send() {
            this.form.post(route('order.store', this.token), {
                preserveState: true,
                preserveScroll: true,
            });
        }
    }
}
</script>

<template>
    <div class="h-screen flex items-center justify-center">
        <div class="bg-white w-[35rem] rounded-lg shadow-2xl">
            <form @submit.prevent="handleForm" class="p-10">
                <!-- Headline -->
                <Headline text="Введіть свою пошту" />
                <Headline class="text-xl !text-left" text="Введіть свою пошту аби ми могли надіслати вам повідомлення для скидання паролю" />

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

                <div class="flex mt-7 mb-5">
                    <BasicButton text="Надіслати повідомлення" type="submit"/>
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
        }
    },
    data() {
        return {
            form: useForm({
                email: '',
            })
        };
    },
    methods: {
        handleForm() {
            this.form.post(route('password.email'), {
                preserveState: true,
                preserveScroll: true
            });
        }
    }
};
</script>

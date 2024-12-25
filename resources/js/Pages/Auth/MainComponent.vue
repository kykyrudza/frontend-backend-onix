<template>
    <div class="h-screen relative">
        <!-- Переход между формами с анимацией -->
        <transition
            name="form-transition"
            @before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
        >
            <div v-if="currentForm === 'login'" class="form-container">
                <LoginForm @switch-form="switchForm('register')" :errors="errors" />
            </div>
        </transition>

        <transition
            name="form-transition"
            @before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
        >
            <div v-if="currentForm === 'register'" class="form-container">
                <RegisterForm @switch-form="switchForm('login')" :errors="errors" />
            </div>
        </transition>

        <transition
            name="form-transition"
            @before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
        >
            <div v-if="currentForm === 'forgot-password'" class="form-container">
                123
            </div>
        </transition>
    </div>
</template>

<script>
import LoginForm from './Forms/LoginForm.vue';
import RegisterForm from './Forms/RegisterForm.vue';
import FormLayout from "../../Layouts/FormLayout.vue";

export default {
    name: 'MainComponent',
    components: {
        LoginForm,
        RegisterForm,
        FormLayout
    },
    props: {
        errors: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            currentForm: '',
            formKey: 0,
        };
    },
    layout: FormLayout,
    mounted() {
        this.updateFormFromRoute();
    },
    watch: {
        $route(to) {
            this.updateFormFromRoute();
        }
    },
    methods: {
        updateFormFromRoute() {
            const path = window.location.pathname;
            if (path.includes('login')) {
                this.currentForm = 'login';
            } else if (path.includes('register')) {
                this.currentForm = 'register';
            } else if (path.includes('forgot-password')) {
                this.currentForm = 'forgot-password';
            }
        },
        switchForm(formName) {
            this.currentForm = formName;
            if (formName === 'login') {
                window.history.pushState({}, '', '/login');
            } else if (formName === 'register') {
                window.history.pushState({}, '', '/register');
            } else if (formName === 'forgot-password') {
                window.history.pushState({}, '', '/forgot-password');
            }

            this.formKey++;
        },
        beforeEnter(el) {
            el.classList.add('transform', 'translate-y-full');
        },
        enter(el, done) {
            el.offsetHeight;
            el.classList.add('transition-transform', 'duration-700', 'ease-in-out');
            el.classList.remove('translate-y-full');
            el.classList.add('translate-y-0');
            done();
        },
        leave(el, done) {
            el.classList.add('transition-transform', 'duration-700', 'ease-in-out');
            el.classList.remove('translate-y-0');
            el.classList.add('translate-y-full');
            done();
        }
    }
};
</script>

<style scoped>
.form-container {
    @apply absolute top-0 left-0 w-full h-full;
}

.form-transition-enter-active, .form-transition-leave-active {
    @apply transition-transform duration-700 ease-in-out;
}

.form-transition-enter, .form-transition-leave-to {
    @apply translate-y-full;
}

.form-transition-enter-to {
    @apply translate-y-0;
}

.form-transition-leave-to {
    @apply translate-y-full;
}
</style>

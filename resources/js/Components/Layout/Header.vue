<template>
    <Container>
        <div class="flex justify-between items-center h-20">
            <div class="items-center lg:flex hidden">
                <UnderLineLink text="Shopify" href="home" />
                <UnderLineLink text="Products" href="products.index" />
                <UnderLineLink text="About Us" href="about" />
                <UnderLineLink text="Contacts" href="contact" />
                <UnderLineLink text="Faq" href="faq" />
            </div>

            <div class="flex items-center lg:hidden">
                <button @click="toggleMenu" class="text-2xl">
                    <i class="ri-menu-2-fill"></i>
                </button>
            </div>

            <BurgerMenu :isOpen="isMenuOpen" @update:isOpen="isMenuOpen = $event" />

            <div class="flex items-center gap-x-2">
                <SearchComponent />
                <div v-if="!auth.user" class="flex gap-x-2 items-center">
                    <MainButton text="Sign Up" href="register" />
                    <span class="border-r h-9 border-zinc-300" />
                    <MainButton text="Login" href="login" />
                </div>
                <div v-else class="flex gap-x-2 items-center">
                    <Link :href="route('cart.index', auth.user.id)" class="w-10 h-10 rounded-full transition-all duration-150 justify-center relative items-center hover:border hover:border-indigo-600 hover:bg-indigo-50 text-2xl hidden lg:flex">
                        <span class="inline-flex absolute top-0 left-6 items-center bg-indigo-100 text-indigo-700 border-indigo-600 border text-[11px] w-5 h-5 font-medium mr-2 justify-center rounded-full p-1">
                          {{ cart_count }}
                        </span>
                        <i class="ri-shopping-cart-line"></i>
                    </Link>
                    <Link :href="route('profile.index', auth.user.id)" class="text-base font-semibold m-3 group relative w-max">
                        <span>
                          {{ auth.user.name }}
                        </span>
                        <span class="absolute -bottom-1 left-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
                        <span class="absolute -bottom-1 right-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
                    </Link>
                </div>
            </div>
        </div>
    </Container>
</template>

<script>
import Container from "@/Components/Layout/Container.vue";
import { Link } from '@inertiajs/vue3';
import BurgerMenu from "@/Components/Layout/BurgerMenu.vue";

export default {
    name: "Header",
    props: {
        auth: {
            type: Object,
            required: true,
        },
        cart_count: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            isMenuOpen: false,
        };
    },
    components: {
        Container,
        Link,
        BurgerMenu,
    },
    methods: {
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        },
    },
};
</script>

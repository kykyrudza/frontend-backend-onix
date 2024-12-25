<template>
    <section v-if="products.length === 0" class="py-24 flex items-center justify-center h-full">
        <div class="mx-auto w-full">
            <div class="lg:py-14 lg:px-20 p-10 rounded-2xl bg-indigo-600 flex items-center justify-between flex-col lg:flex-row">
                <div class="block text-center mb-5 lg:text-left lg:mb-0">
                    <h2 class="font-manrope text-4xl text-white font-semibold mb-5 lg:mb-2">
                        Ваша корзина порожня!
                    </h2>
                    <p class="text-xl text-indigo-100">
                        Заповніть її товарами з нашого магазину!
                    </p>
                </div>
                <Link
                    :href="route('products.index')"
                    class="flex items-center gap-2 bg-white rounded-full shadow-sm text-lg text-indigo-600 font-semibold py-4 px-8 transition-all duration-500">
                    Перейти до магазину
                    <svg width="19" height="14" viewBox="0 0 19 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.75 7L16.4167 7M11.8333 12.5L16.6852 7.64818C16.9907 7.34263 17.1435 7.18985 17.1435 7C17.1435 6.81015 16.9907 6.65737 16.6852 6.35182L11.8333 1.5"
                            stroke="#4F46E5"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </Link>
            </div>
        </div>
    </section>

    <section v-else class="py-24 relative">
        <h2 class="title font-manrope font-bold text-4xl leading-10 mb-8 text-center text-black">
            Shopping Cart
        </h2>

        <div class="hidden lg:grid grid-cols-2 py-6">
            <div class="font-normal text-start text-xl leading-8 text-gray-500">
                Product
            </div>
            <div class="font-normal text-end text-xl leading-8 text-gray-500">
                Total
            </div>
        </div>

        <div v-for="product in state.products" :key="product.id">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border-t border-gray-200 py-6">
                <div class="flex items-center gap-3 min-[550px]:gap-6 w-full ">
                    <div class="img-box">
                        <img
                            v-if="product.main_image"
                            :src="imageUrl(product.main_image)"
                            alt="product image"
                            class="xl:w-[140px] rounded-xl w-52 object-cover"
                        />
                    </div>
                    <div class="pro-data w-full max-w-sm ">
                        <h5 class="font-semibold text-xl leading-8 text-black max-[550px]:text-center">
                            {{ product.name }}
                        </h5>
                        <p class="font-normal text-lg leading-8 text-gray-500 my-2 min-[550px]:my-3 max-[550px]:text-center">
                            {{ product.category.name }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center relative justify-between w-full gap-2">

                    <div class="flex items-center justify-center">
                        <button
                            @click="removeItem(product)"
                            class="group rounded-full w-12 text-xl h-12 border border-red-500 bg-red-500 text-white flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-red-600 hover:bg-red-600"
                        >
                            <i class="ri-delete-bin-6-line"></i>
                        </button>
                    </div>

                    <h5 class="font-manrope font-bold text-2xl leading-9 text-indigo-600 w-full max-w-[176px] text-center">
                        ${{ product.total.toFixed(2) }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-6 w-full mb-8">
            <div class="flex items-center justify-between w-full py-6">
                <p class="font-manrope font-medium text-2xl leading-9 text-gray-900">
                    Total
                </p>
                <h6 class="font-manrope font-medium text-2xl leading-9 text-indigo-500">
                    ${{ totals.total }}
                </h6>
            </div>
        </div>

        <div class="flex items-center flex-col sm:flex-row justify-center gap-3 mt-8">
            <button
                @click="sendCartToServer"
                class="rounded-full w-full max-w-[280px] py-4 text-center justify-center items-center bg-indigo-600 font-semibold text-lg text-white flex transition-all duration-500 hover:bg-indigo-700">Continue to Payment
                <svg class="ml-2" xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22"
                     fill="none">
                    <path d="M8.75324 5.49609L14.2535 10.9963L8.75 16.4998" stroke="white" stroke-width="1.6"
                          stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </section>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { Link } from '@inertiajs/vue3'
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    products: {
        type: Array,
        required: true
    },
    domain: {
        type: String,
        required: true
    }
});

const state = reactive({
    products: props.products.map(product => ({
        ...product,
        quantity: product.quantity || 1,
        discount: product.discount || 0,
        total: (product.price || 0) * (product.quantity || 1) - (product.discount || 0) * (product.quantity || 1)
    }))
});

const updateTotal = (product) => {
    product.total = (product.price * product.quantity) - (product.discount * product.quantity);
};

const totals = computed(() => {
    const subtotal = state.products.reduce((total, product) => total + (product.price * product.quantity), 0);
    const discount = state.products.reduce((total, product) => total + (product.discount * product.quantity), 0);
    const total = subtotal - discount;

    return {
        subtotal: subtotal.toFixed(2),
        discount: discount.toFixed(2),
        total: total.toFixed(2)
    };
});

const sendCartToServer = (products) => {
    const productIds = state.products.map(product => product.id);

    Inertia.post(route('products.cart_to_checkout', { products_id: productIds }), {
        products: state.products
    });
};

const removeItem = (product) => {
    Inertia.post(route('products.delete-from-cart', { slug: product.slug }))
};

const imageUrl = (main_image) => {
    return main_image?.image_path ? `${props.domain}${main_image.image_path}` : '';
};
</script>

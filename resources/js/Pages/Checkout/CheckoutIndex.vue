<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Перевірка замовлення
        </h1>

        <table class="min-w-full table-auto">
            <thead>
            <tr class="border-b">
                <th class="text-center p-4">Товар</th>
                <th class="text-center p-4">Назва</th>
                <th class="text-center p-4">Ціна</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id" class="border-b">
                <td class="p-4 text-center w-1/3">
                    <div class="flex items-center justify-center">
                        <img
                            v-if="product.main_image"
                            :src="imageUrl(product.main_image)"
                            alt="product image"
                            class="xl:w-[140px] rounded-xl w-52 object-cover"
                        />
                    </div>
                </td>
                <td class="p-4 text-center w-1/3">
                    <h5 class="font-semibold sm:!text-xl leading-8 text-black">
                        {{ product.name }}
                    </h5>
                </td>
                <td class="p-4 text-center w-1/3">
                    <h6 class="font-medium text-lg leading-8 text-indigo-600">
                        ${{ product.price }}
                    </h6>
                </td>
            </tr>
            </tbody>
        </table>

       <div class="flex items-center justify-between my-2 rounded-md p-10 bg-zinc-50">
           <div class="sm:!text-xl font-bold">
               Загальна сумма: ${{ totalAmount }}
           </div>

           <button @click="proceedToNextStep" class="bg-indigo-600 px-2 py-1 text-white sm:!px-4 sm:!py-2 rounded hover:bg-indigo-700">
               Перейти до оформлення
           </button>
       </div>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
export default {
    name: "CheckoutIndex",
    props: {
        products: {
            type: Object,
            required: true
        },
        domain: {
            type: String,
            required: true
        }
    },
    computed: {
        totalAmount() {
            return this.products.reduce((total, product) => total + parseFloat(product.price), 0).toFixed(2);
        }
    },
    methods: {
        imageUrl(main_image) {
            return main_image?.image_path ? `${this.domain}${main_image.image_path}` : '';
        },
        proceedToNextStep() {
            Inertia.post(route('checkout.store'));
        }
    }
}
</script>

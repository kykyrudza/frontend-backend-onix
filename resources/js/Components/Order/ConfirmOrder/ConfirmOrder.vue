<template>
    <div class="text-center py-12">
        <Headline text="Перевірка інформації" />
    </div>

    <div class="grid grid-cols-1 sm:!grid-cols-2">

        <div class="col-span-1">
            <div class="rounded-lg shadow-lg p-4 m-4">
                <div class="w-full">
                    <p class="text-2xl font-mono font-bold">
                        Замовник
                    </p>
                    <div class="w-full border-b my-3 border-zinc-400" />
                    <InfoRow label="Повне Ім'я" :value="user.name" />
                    <InfoRow label="Номер телефону" :value="user.phone" />
                    <InfoRow label="Електронна пошта" :value="user.email" />
                </div>
            </div>
        </div>

        <div class="col-span-1">
            <div class="rounded-lg shadow-lg p-4 m-4 flex">
                <BasicButton
                    :disabled="!products.length"
                    @click="processPayment"
                    type="button"
                    text="Оплатити картою (PayPal)"
                />
            </div>
        </div>

        <div class="col-span-1">
            <div class="rounded-lg shadow-lg p-4 m-4">
                <div class="w-full">
                    <p class="text-2xl font-mono font-bold">
                        Данні про доставку
                    </p>
                    <div class="w-full border-b my-3 border-zinc-400" />
                    <InfoRow label="Тип доставки" :value="method.name" />
                    <InfoRow label="Вартість доставки" :value="method.price" />
                    <InfoRow label="Місто" :value="data.city" />
                    <InfoRow label="Регіон" :value="data.region" />
                    <InfoRow v-if="data.house" label="Повна адресса" :value="data.street + ' ' + data.house" />
                    <InfoRow v-if="data.date" label="Очікувана дата доставки" :value="data.date" />
                    <InfoRow v-if="data.postal_code" label="Поштовий Індекс" :value="data.postal_code" />
                    <InfoRow v-if="data.postOffices" label="Поштове віділленя" :value="data.postOffices" />
                    <InfoRow v-if="data.comments" label="Коментар" :value="data.comments" />
                </div>
            </div>
        </div>

        <div class="col-span-1">
            <div class="p-6 rounded-lg space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Ваши товари</h2>
                <div v-for="product in products" :key="product.id" class="flex items-center space-x-4 p-4 border-b border-gray-200">
                    <img :src="imageUrl(product.main_image)" alt="{{ product.name }}" class="w-16 h-16 object-cover rounded-lg">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">{{ product.name }}</h3>
                        <p class="text-sm text-gray-600">${{ product.price }}</p>
                    </div>
                </div>
                <div class="text-right font-semibold text-lg">
                    <span class="mx-2">Общая сумма:</span>
                    <span class="text-indigo-600">${{ totalPrice }}</span>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import Headline from "@/Components/Forms/Headline.vue";
import BasicButton from "@/Components/Forms/BasicButton.vue";
import InfoRow from "@/Components/Order/Index/InfoRow.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: 'ConfirmOrder',
    components: {BasicButton, Headline, InfoRow},
    props: {
        token: String,
        data: Object,
        method: Object,
        products: Array,
        user: Object,
        domain: String,
    },
    computed: {
        totalPrice() {
            const total = this.products.reduce((total, product) => total + (Number(product.price) || 0), 0) + (Number(this.method.price) || 0);
            if (isNaN(total)) {
                console.error("Вибачте, ми не можемо порахувати вартість вашої покупки.");
            }
            return total;
        }
    },
    data() {
        return {
            activeTab: 'paypal',
        }
    },
    methods: {
        imageUrl(main_image) {
            return main_image?.image_path ? `${this.domain}${main_image.image_path}` : '';
        },
        processPayment() {
            const userData = JSON.parse(JSON.stringify(this.user));
            const productsData = JSON.parse(JSON.stringify(this.products));
            const deliveryData = JSON.parse(JSON.stringify(this.method));

            console.log('Sending payment request with data:', {
                user: userData,
                products: productsData,
                delivery: deliveryData,
                total_price: this.totalPrice
            });

            console.log("User data:", userData);
            console.log("Products data:", productsData);
            console.log("Delivery method:", deliveryData);
            console.log("Total price:", this.totalPrice);

            Inertia.post('/create-paypal-payment', {
                user: userData,
                products: productsData,
                delivery: deliveryData,
                total_price: this.totalPrice
            });
        }
    }
}
</script>

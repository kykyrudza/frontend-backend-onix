<template>
    <div class="h-full ">
        <div v-for="product in products" :key="product.id" class="border-b flex justify-center items-center">
            <div class="p-4 text-center w-1/3">
                <div class="flex items-center justify-center">
                    <img
                        v-if="product.main_image"
                        :src="imageUrl(product.main_image)"
                        alt="product image"
                        class="xl:w-[140px] rounded-xl w-52 object-cover"
                    />
                </div>
            </div>
            <div class="p-4 text-center w-2/3">
                <h5 class="font-semibold text-md leading-8 text-black">
                    {{ product.name }}
                </h5>
                <h6 class="font-medium text-lg leading-8 text-indigo-600">
                    ${{ product.price }}
                </h6>
            </div>
        </div>
        <div class="p-6 w-full flex items-center justify-end  mb-8 max-lg:max-w-xl max-lg:mx-auto">
            <div class="flex items-center justify-between w-full py-6">
                <p class="font-manrope font-medium text-2xl leading-9 text-gray-900">
                    Total
                </p>
                <h5 class="font-manrope font-medium text-2xl leading-9 text-indigo-500">
                    ${{ totalPrice.toFixed(2) }}
                </h5>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductBlock",
    props: {
        products: {
            type: Array,
            required: true
        },
        domain: {
            type: String,
            required: true
        }
    },
    methods: {
        imageUrl(main_image) {
            return main_image?.image_path ? `${this.domain}${main_image.image_path}` : '';
        },
    },
    computed: {
        totalPrice() {
            return this.products.reduce((total, product) => {
                const quantity = product.quantity ?? 1;
                return total + (product.price * quantity);
            }, 0);
        }
    }
}
</script>

<template>
    <div class="py-12">
        <Headline :text="category.name"/>

        <div class="flex-grow transition-all duration-500 ease-in-out">
            <ProductSectionAllProducts
                :showFilter="false"
                :products="products"
                :domain="domain"
            />
        </div>
    </div>
</template>

<script>
import ProductSectionAllProducts from "@/Components/Products/ProductSection/ProductSectionAllProducts.vue";
import {Link} from "@inertiajs/vue3";
import Headline from "@/Components/Forms/Headline.vue";
export default {
    props: {
        category: Object,
        products: Object,
        currentPage: Number,
        lastPage: Number,
        total: Number,
        perPage: Number,
        domain: String
    },
    components: {
        Headline,
        Link,
        ProductSectionAllProducts
    }
};
</script>

<template>
    <div class="py-12">
        <Headline :text="category.name"/>
        <div class="flex w-full items-center justify-between" >
            <Link
                v-for="child in category.all_children" :key="child.id"
                :href="route('categories.show.subcategory', {subcategory_slug: child.slug})"
                class="text-base font-semibold my-5 group relative w-max">
                {{ child.name }}
                <span class="absolute -bottom-1 left-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
                <span class="absolute -bottom-1 right-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
            </Link>
        </div>
        <div class="flex-grow transition-all duration-500 ease-in-out">
            <ProductSectionAllProducts
                :domain="domain"
                :showFilter="false"
                :products="products"
            />
        </div>
    </div>
</template>

<script>
import ProductSectionAllProducts from "@/Components/Products/ProductSection/ProductSectionAllProducts.vue";
import {Link} from "@inertiajs/vue3";
import Headline from "@/Components/Forms/Headline.vue";
import UnderLineLink from "@/Components/Links/UnderLineLink.vue";
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
        UnderLineLink,
        Headline,
        Link,
        ProductSectionAllProducts
    }
};
</script>

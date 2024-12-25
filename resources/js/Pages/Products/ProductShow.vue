<template>
    <section class="py-12 lg:py-24">
        <ProductSliderSection
            :auth="auth"
            :domain="domain"
            :product="product"
            :characteristics="characteristics"
        />
        <ProductReviewSection
            :reviews="reviews"
        />
    </section>
</template>

<script>
import ProductSliderSection from "@/Components/Products/ProductShow/ProductSliderSection.vue";
import ProductReviewSection from "@/Components/Products/ProductShow/ProductReviewSection.vue";

export default {
    name: "ProductShow",
    components: {
        ProductReviewSection,
        ProductSliderSection
    },
    props: {
        product: {
            type: Object,
            required: true,
        },
        characteristics: {
            type: Object,
            required: true,
        },
        domain: {
            type: String,
            required: true,
        },
        reviews: {
            type: Object,
            required: true
        },
        auth: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>
</style>

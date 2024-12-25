
<template>

    <HeaderSection />

    <div class="w-full lg:flex min-h-[40rem]">
        <div class="p-4 h-full !w-full lg:!w-1/2">
            <h1 class="text-2xl pb-3 text-center font-mono">
                Найбільш продаваємі товари магазину
            </h1>
            <div class="grid grid-cols-1 gap-2">
                <div v-for="product in most_sold_in_store" class="shadow rounded-lg">
                    <Link :href="route('products.show', product.slug)">
                        <div class="flex items-center">
                            <img :src="product.image" alt="product.name" class="w-36" />
                            <div>
                                <p class="text-lg">{{product.name }}</p>
                                <p class="text-indigo-700">${{product.price }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
        <div class="hidden w-60 xl:!inline-block h-[40rem] relative">
            <span class="border-l absolute right-1/2 border-zinc-900 inline-block !h-full rotate-12"></span>
        </div>
        <div class=" p-4 h-full relative !w-full lg:!w-1/2">
            <h1 class="text-2xl pb-3 text-center font-mono">
                Найбільш продаваємі товари в "{{ region }}"
            </h1>
            <div class="grid grid-cols-1 gap-2">
                <div v-for="product in most_sold_in_region" class="shadow rounded-lg">
                    <Link :href="route('products.show', product.slug)">
                        <div class="flex items-center">
                            <img :src="product.image" alt="product.name" class="w-36" />
                            <div>
                                <p class="text-lg">{{product.name }}</p>
                                <p class="text-indigo-700">${{product.price }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>

    <CategoriesMenu :categories="categories" />

    <Blocks />

    <Steps />

   <TechnologyStack />

</template>


<script>
import CategoriesMenu from "@/Components/Categories/CategoriesMenu.vue";
import BasicButton from "@/Components/Forms/BasicButton.vue";
import Blocks from "@/Components/Home/Blocks.vue";
import Steps from "@/Components/Home/Steps.vue";
import TechnologyStack from "@/Components/Home/TechnologyStack.vue";
import HeaderSection from "@/Components/Home/HeaderSection.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: 'Home',
    components: {
        HeaderSection,
        TechnologyStack,
        Blocks,
        Steps,
        BasicButton,
        CategoriesMenu,
        Link
    },
    props: {
        categories: Object,
        most_sold_in_store: Object,
        most_sold_in_region: Object,
        region: String,
    }
}
</script>

<style>

</style>

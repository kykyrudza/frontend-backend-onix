<template>
    <div class="relative bg-white">
        <Headline text="Наш асортимент розділяється!" />
        <div class="flex border-b py-5 items-center justify-around">
            <Link
                v-for="category in categories" :key="category.id"
                :href="route('categories.show', category.slug)"
                class="text-2xl font-semibold group relative w-max">
                {{ category.name }}
                <span class="absolute -bottom-1 left-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
                <span class="absolute -bottom-1 right-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
            </Link>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import Headline from "@/Components/Forms/Headline.vue";

export default {
    name: 'CategoriesMenu',
    components: {Headline, Link},
    props: {
        categories: Array
    },
}
</script>

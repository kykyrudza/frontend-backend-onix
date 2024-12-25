
<template>
    <Container>
        <footer class="w-full py-8">
            <div class="mx-auto">
                <ul class="text-lg flex items-center justify-center flex-col gap-7 md:flex-row md:gap-12 transition-all duration-500 py-8 mb-10 border-b border-gray-200">
                    <li>
                        <Link :href="route('home')" class="text-gray-800 hover:text-gray-900">
                            Home
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('products.index')" class=" text-gray-800 hover:text-gray-900">
                            Products
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('contact')" class=" text-gray-800 hover:text-gray-900">
                            Contacts
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('about')" class=" text-gray-800 hover:text-gray-900">
                            About Us
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('faq')" class=" text-gray-800 hover:text-gray-900">
                            FAQ
                        </Link>
                    </li>
                </ul>
                <span class="text-lg text-gray-500 text-center block">©<Link :href="route('home')">shopify</Link> 2024, All rights reserved.</span>
            </div>
        </footer>
    </Container>
</template>

<script>
import Container from "@/Components/Layout/Container.vue";
import {Link} from "@inertiajs/vue3";
import UnderLineLink from "@/Components/Links/UnderLineLink.vue";

export default {
    name: "Footer",
    components: {
        UnderLineLink,
        Container,
        Link
    }
}
</script>

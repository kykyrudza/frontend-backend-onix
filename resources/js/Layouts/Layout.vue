
<template>
    <div v-auto-animate class="overflow-y-hidden min-h-screen">
        <!-- Header -->
        <header class="border-b border-zinc-200" auth="" cart_count="" products="">
            <Header :auth="auth" :cart_count="cart_count" />
        </header>

        <!-- Main Content -->
        <main class="h-auto max-w-screen">
            <Container>
                <slot />
            </Container>
        </main>

        <!-- Footer -->
        <footer class="border-t border-zinc-200 h-auto">
            <Footer />
        </footer>
    </div>
</template>

<script>
import Header from '../Components/Layout/Header.vue'
import Footer from '../Components/Layout/Footer.vue'
import Container from "../Components/Layout/Container.vue";
export default {
    name: 'Layout',
    components: {
        Header,
        Footer,
        Container
    },
    props: {
        auth: {
            type: Object,
            required: true,
        },
        cart_count: {
            type: Number,
            required: true,
        },
    }
}
</script>

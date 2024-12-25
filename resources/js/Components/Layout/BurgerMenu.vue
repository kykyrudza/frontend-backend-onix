<template>
    <transition name="menu-fade" @before-enter="beforeEnter" @enter="enter" @leave="leave">
        <div v-if="isOpen" class="fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black bg-opacity-50" @click="closeMenu"></div>

            <div class="absolute left-0 top-0 grid grid-cols-4 bottom-0 bg-white pt-3 w-64 shadow-lg transform transition-transform duration-300 ease-in-out" :class="{'translate-x-0': isOpen, '-translate-x-full': !isOpen}">
                <ul class="flex flex-col col-span-3 items-start px-4 gap-y-2 text-lg">
                    <li><UnderLineLink text="Shopify" href="home" /></li>
                    <li><UnderLineLink text="Products" href="products.index" /></li>
                    <li><UnderLineLink text="About Us" href="about" /></li>
                    <li><UnderLineLink text="Contacts" href="contact" /></li>
                    <li><UnderLineLink text="Faq" href="faq" /></li>
                </ul>
                <div class="flex col-span-1 justify-start items-start pl-4">
                    <button @click="closeMenu" class="text-black text-2xl">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "BurgerMenu",
    props: {
        isOpen: Boolean,
    },
    watch: {
        isOpen(newVal) {
            if (newVal) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    },
    methods: {
        closeMenu() {
            this.$emit("update:isOpen", false);
        },
        beforeEnter(el) {
            el.style.transform = "translateX(-100%)";
        },
        enter(el, done) {
            el.offsetHeight;
            el.style.transition = "transform 0.3s ease-out";
            el.style.transform = "translateX(0)";
            done();
        },
        leave(el, done) {
            el.style.transition = "transform 0.3s ease-out";
            el.style.transform = "translateX(-100%)";
            done();
        },
    },
};
</script>

<style scoped>
.menu-fade-enter-active,
.menu-fade-leave-active {
    transition: opacity 0.3s ease;
}
.menu-fade-enter, .menu-fade-leave-to {
    opacity: 0;
}

.menu-enter-active, .menu-leave-active {
    transition: transform 0.3s ease;
}
.menu-enter, .menu-leave-to {
    transform: translateX(-100%);
}
</style>

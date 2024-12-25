<template>
    <div class="flex justify-center items-center min-h-screen">
        <div class="text-center bg-white p-10 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-3xl font-semibold font-mono text-red-600 mb-4">Сталася помилка</h2>
            <p class="text-lg text-red-500 mb-6">{{ message }}</p>
            <button @click="goHome" class="inline-block py-3 px-6 bg-indigo-500 text-white rounded-lg text-xl hover:bg-indigo-600 transition duration-300">
                Повернутися на головну
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: String,
    },
    methods: {
        goHome() {
            window.location.href = "/";
        }
    }
}
</script>

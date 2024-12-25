<template>
    <div class="flex justify-center items-center min-h-screen">
        <div class="text-center bg-white p-10 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-3xl font-semibold font-mono text-indigo-500 mb-4">
                {{ message }}
            </h2>
            <p class="text-lg text-gray-600 mb-6">
                Ви скасували платіж, якщо це була помилка, спробуйте ще раз.
            </p>
            <button @click="goHome" class="inline-block py-3 px-6 bg-indigo-500 text-white rounded-lg text-xl hover:bg-indigo-600 transition duration-300">
                Повернутися на головну
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        }
    },
    methods: {
        goHome() {
            window.location.href = "/";
        }
    }
}
</script>

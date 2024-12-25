<template>
    <div class="flex items-center w-full">
        <template v-for="(step, index) in steps" :key="step.name">
            <!-- Step icon -->
            <div class="flex items-center">
                <div :class="[
                    'flex items-center justify-center w-10 h-10 rounded-full',
                    getStepClass(index),
                    'text-white'
                ]">
                    <i :class="step.icon + ' text-2xl'"></i>
                </div>
            </div>

            <!-- Progress bar -->
            <div v-if="index < steps.length - 1" class="flex-1 h-1 bg-zinc-300">
                <div :class="['h-1 bg-green-600']" :style="{ width: getProgressWidth(index) }"></div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: "ProgressBar",
    props: {
        userCreate: {
            type: Boolean,
            required: true
        },
        addAddress: {
            type: Boolean,
            required: true
        },
        confirmOrder: {
            type: Boolean,
            required: true
        },
    },
    data() {
        return {
            steps: [
                { name: 'userCreate', icon: 'ri-user-line' },
                { name: 'addAddress', icon: 'ri-file-list-line' },
                { name: 'confirmOrder', icon: 'ri-check-line' },
            ]
        }
    },
    methods: {
        getStepClass(index) {
            const currentStep = this.getCurrentStep();
            if (index <= currentStep) {
                return 'bg-green-600';
            }
            return 'bg-zinc-300';
        },
        getProgressWidth(index) {
            const currentStep = this.getCurrentStep();
            if (index < currentStep) {
                return '100%';
            } else if (index === currentStep) {
                return '50%';
            }
            return '0%';
        },
        getCurrentStep() {
            if (this.confirmOrder) return 2;
            if (this.addAddress) return 1;
            if (this.userCreate) return 0;
            return -1;
        }
    }
}
</script>

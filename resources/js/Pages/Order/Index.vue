<template>
    <div class="w-full h-full py-12">
        <div class="grid lg:!grid-cols-8 gap-x-3 grid-cols-1">
            <div :class="{
                'col-span-1 lg:col-span-8': confirmOrder,
                'col-span-1 lg:col-span-5': !confirmOrder
            }">
                <div class="top-0">
                    <ProgressBar
                        :userCreate="userCreate"
                        :addAddress="addAddress"
                        :confirmOrder="confirmOrder"
                    />
                </div>
                <div v-if="userCreate">
                    <CreateUserForm
                        :token="token"
                        :errors="errors"
                    />
                </div>
                <div v-if="addAddress">
                    <AddAddress
                        :errors="errors"
                        :regions="regions"
                        :postOffices="postOffices"
                        :token="token"
                        :cities="cities"
                    />
                </div>
                <div v-if="confirmOrder">
                   <ConfirmOrder
                       :data="data"
                       :method="method"
                       :user="user"
                       :token="token"
                       :products="products"
                       :domain="domain"
                   />
                </div>
            </div>
            <div v-if="!confirmOrder" class="col-span-1 lg:col-span-3 border rounded-xl p-2 w-full">
                <ProductBlock :products="products" :domain="domain" />
            </div>
        </div>
    </div>
</template>

<script>
import ProgressBar from "@/Components/Order/Index/ProgressBar.vue";
import ProductBlock from "@/Components/Order/Index/ProductBlock.vue";
import CreateUserForm from "@/Components/Order/CrearteUser/CreateUserForm.vue";
import AddAddress from "@/Components/Order/AddAddress/AddAddress.vue";
import ConfirmOrder from "@/Components/Order/ConfirmOrder/ConfirmOrder.vue";

export default {
    name: "Index",
    components: {ConfirmOrder, AddAddress, CreateUserForm, ProductBlock, ProgressBar},
    props: {
        products: {
            type: Array,
            required: true
        },
        domain: {
            type: String,
            required: true
        },
        token: {
            type: String,
            required: true
        },
        errors: {
            type: Object,
            default: () => ({})
        },
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
        cities: {
            type: Object,
            default: () => ({})
        },
        regions: {
            type: Object,
            default: () => ({})
        },
        postOffices: {
            type: Object,
            default: () => ({})
        },
        data: {
            type: Object,
            default: () => ({})
        },
        method: {
            type: Object,
            default: () => ({})
        },
        user: {
            type: Object,
            default: () => ({})
        }
    },
    watch: {
        confirmOrder(newValue) {
            console.log('Confirm order status changed:', newValue);
        }
    }

};
</script>

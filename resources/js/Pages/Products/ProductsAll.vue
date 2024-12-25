<template>
    <div>
        <div class="flex py-4 transition-all duration-500 gap-x-5">

            <div class="transition-all duration-500 ease-in-out lg:block hidden"
                 :style="filtersVisible ? 'width: 356px;' : 'width: 0px;'">
                <FiltersBlock v-if="filtersVisible" :filtersOptions="filtersOptions" @filter-applied="handleFilterApplied" @filter-updated="handleFilterUpdated" />
            </div>

            <div class="flex-grow transition-all duration-500 ease-in-out"
                 :style="filtersVisible ? 'width: calc(100% - 256px);' : 'width: 100%;'">
                <ProductSectionAllProducts
                    :toggleFilters="toggleFilters"
                    :domain="domain"
                    :showFilter="true"
                    :products="products"
                />
                <Pagination :current-page="currentPage"
                            :last-page="lastPage"
                            :total="total"
                            :per-page="perPage"
                            @page-changed="handlePageChange" />
            </div>
        </div>

        <div class="lg:hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-50"
             v-if="burgerMenuVisible" @click="closeBurgerMenu">
            <div class="absolute top-0 left-0 bg-white w-80 h-full overflow-y-auto"
                 @click.stop>
                <FiltersBlock v-if="filtersVisible" :filtersOptions="filtersOptions" @filter-applied="handleFilterApplied" @filter-updated="handleFilterUpdated" />
            </div>
        </div>
    </div>
</template>

<script>
import FiltersBlock from "@/Components/Products/Filters/FiltersBlock.vue";
import ProductSectionAllProducts from "@/Components/Products/ProductSection/ProductSectionAllProducts.vue";
import Pagination from "@/Components/Products/Pagination/Pagination.vue";

export default {
    name: "ProductsAll",
    components: {
        Pagination,
        FiltersBlock,
        ProductSectionAllProducts
    },
    props: {
        products: {
            type: Array,
            required: true,
        },
        domain: String,
        currentPage: Number,
        lastPage: Number,
        total: Number,
        perPage: Number,
        filtersOptions: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            filtersVisible: true,
            burgerMenuVisible: false,
        };
    },
    methods: {
        toggleFilters() {
            if (window.innerWidth < 1024) {
                this.burgerMenuVisible = !this.burgerMenuVisible;
                this.toggleBodyOverflow();
            } else {
                this.filtersVisible = !this.filtersVisible;
            }
        },
        handlePageChange(page) {
            this.$inertia.get('/products', {page});
        },
        closeBurgerMenu() {
            this.burgerMenuVisible = false;
            this.toggleBodyOverflow();
        },
        handleFilterApplied() {
            if (this.burgerMenuVisible) {
                return;
            } else {
                this.burgerMenuVisible = false;
                this.toggleBodyOverflow();
            }
        },
        handleFilterUpdated(newFilters) {
            this.filtersOptions = {...newFilters};
            this.$inertia.get('/products', this.filtersOptions);
        },
        toggleBodyOverflow() {
            if (this.burgerMenuVisible) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    },
};
</script>

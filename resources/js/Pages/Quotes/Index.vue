<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">


                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import {Quotes} from "@/Types/quotes";
import {PropType} from "vue";


export default {
    name: "Index",
    components: {
        AppLayout,
        Welcome
    },
    props: {
        quotes: {
            type: Array as PropType<Quotes[]>,
            required: true
        }
    },
    mounted() {
        console.log(this.quotes);
    }
}
</script>

<style scoped>

</style>

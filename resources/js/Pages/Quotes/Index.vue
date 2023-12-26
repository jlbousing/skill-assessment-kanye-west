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

                    <LoadingSpinner v-if="loading" class="flex justify-center"></LoadingSpinner>
                    <ul class="p-2" v-else>
                        <li v-for="(item,index) in quotes"
                            :key="index"
                             class="my-4 border-2 rounded-lg lg:py-4">
                            {{item.quote}}
                        </li>
                    </ul>

                    <button class="p-2 bg-blue-400 text-white rounded-lg pointer
                                   focus:bg-blue-300"
                                   @click="refresh()"
                    >Refresh Quotes</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import LoadingSpinner from '@/Components/LoadingSpinner.vue';

import {Quotes} from "@/Types/quotes";
import {KanyeQuote} from "@/Types/KanyeQuote";
import {PropType, ref} from "vue";
import axios from "axios";


export default {
    name: "Index",
    components: {
        AppLayout,
        LoadingSpinner
    },
    props: {
        quotes: {
            type: Array as PropType<KanyeQuote[]>,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            quotes: ref(this.$props.quotes),
            lastRequestTime: 0,
            requestsCount: 0
        }
    },
    methods: {
        refresh: async function() {

            if(!this.loading) {

                try {
                    this.loading = true;
                    const response = await axios.get("quotes/refresh");
                    this.$data.quotes = response.data.data;
                    this.loading = false;
                    console.log(this.quotes);
                } catch (error) {
                    console.error('Error al actualizar las citas', error);
                    this.loading = false;
                }
            }
        }
    }
}
</script>

<style scoped>

</style>

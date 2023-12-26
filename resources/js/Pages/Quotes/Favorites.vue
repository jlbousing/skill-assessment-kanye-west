<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Favorites Quotes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <LoadingSpinner v-if="loading" class="flex justify-center"></LoadingSpinner>
                    <ul class="p-2" v-else>
                        <li v-for="(item,index) in quotes"
                            :key="index"
                            class="my-4 border-2 rounded-lg lg:py-4
                                    flex">
                            <span class="w-[95%]">{{item.text}}</span>
                            <button class="pointer" @click="deleteQuote(item)">
                                <TrashIcon class="h-6 w-6 items-center text-red-500" />
                            </button>

                        </li>
                    </ul>

                    <span v-if="quotes.length <= 0">You don`t have any favorites quotes</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import LoadingSpinner from '@/Components/LoadingSpinner.vue';
import {TrashIcon} from "@heroicons/vue/16/solid";
import {Quotes} from "@/Types/quotes";
import { User} from "@/Types/User";
import {PropType, ref} from "vue";
import axios from "axios";


export default {
    name: "Favorites",
    components: {
        AppLayout,
        LoadingSpinner,
        TrashIcon
    },
    props: {
        quotes: {
            type: Array as PropType<Quotes[]>,
            required: true
        },
        user: {
            type: Object as PropType<User>,
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
        deleteQuote: async function(quote: Quotes) {
            this.loading = true;
            try {

                const result = await axios.delete(`${quote.id}`);

                if(result.status === 200) {
                    const index = this.quotes.indexOf(quote);
                    this.quotes.splice(index,1);
                }

                this.loading = false;
            } catch (error) {
                console.log("error al eliminar quote ",error)
                this.loading = false;
            }
        }
    },
    mounted() {
        console.log("probando quotes ",this.quotes);
    }
}
</script>

<style scoped>

</style>

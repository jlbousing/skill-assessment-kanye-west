<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quotes
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
                                <span class="w-[95%]">{{item.quote}}</span>
                            <button class="pointer" @click="addFavoriteQuote(item)">
                                <HeartIcon class="h-6 w-6 items-center"
                                           :class="{'text-red-500': item.isFavorite, 'text-red-200': !item.isFavorite}"/>
                            </button>

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
import {HeartIcon} from "@heroicons/vue/16/solid";
import {Quotes} from "@/Types/quotes";
import { User} from "@/Types/User";
import {KanyeQuote} from "@/Types/KanyeQuote";
import {PropType, ref} from "vue";
import axios from "axios";


export default {
    name: "Index",
    components: {
        AppLayout,
        LoadingSpinner,
        HeartIcon
    },
    props: {
        quotes: {
            type: Array as PropType<KanyeQuote[]>,
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
        },
        addFavoriteQuote: async function(quote: KanyeQuote) {

            if(!quote.isFavorite) {

                const quoteFav: Quotes = {
                    user_id: this.user.id,
                    text: quote.quote
                }

                console.log("nuevo qute ",quoteFav);

                try {

                    const result = await axios.post("quotes",quoteFav);

                    if(result.status == 201) {
                        const index = this.quotes.indexOf(quote);
                        this.quotes[index].isFavorite = true;
                    }
                } catch (error) {
                    console.log("error al guardar cita", error)
                }

            }else {

                try {

                    const result = await axios.delete(`quotes/text/${quote.quote}`);

                    if(result.status === 200) {
                        console.log("hey bro")
                        const index = this.quotes.indexOf(quote);
                        this.quotes[index].isFavorite = false;
                    }

                } catch (error) {
                    console.log("error al eliminar quote ",error)
                }
            }
        }
    }
}
</script>

<style scoped>

</style>

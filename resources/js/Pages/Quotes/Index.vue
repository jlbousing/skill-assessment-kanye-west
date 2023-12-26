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

                    <ul class="p-2">
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
import Welcome from '@/Components/Welcome.vue';
import {Quotes} from "@/Types/quotes";
import {KanyeQuote} from "@/Types/KanyeQuote";
import {PropType} from "vue";
import axios from "axios";


export default {
    name: "Index",
    components: {
        AppLayout,
        Welcome
    },
    props: {
        quotes: {
            type: Array as PropType<KanyeQuote[]>,
            required: true
        }
    },
    methods: {
        refresh: async function() {
            try {
                const response = await axios.get('https://api.kanye.rest');
                console.log(response);
                //const newQuote = { quote: response.data.quote }; // Asegúrate de que la estructura coincida con tu tipo Quotes
                //quotes.value = [newQuote, ...quotes.value]; // Agrega la nueva cita al principio del array
            } catch (error) {
                console.error('Error al actualizar las citas', error);
            }
        }
    }
}
</script>

<style scoped>

</style>

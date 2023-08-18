<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import { getToday } from '@/common';
import axios from 'axios';
import Chart from '@/Components/Chart.vue';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';

dayjs.locale('ja');

onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay'
})

const data = reactive({})

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type
            }
        })
            .then(res => {
                data.data = res.data.data
                data.labels = res.data.labels
                data.totals = res.data.totals
                console.log(res.data)
            })
    } catch (e) {
        console.log(e.message)
    }
}

</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="md:p-6">

                        <form @submit.prevent="getData">
                            <div class="md:flex justify-center p-6 mb-6">
                                <div class="font-medium">
                                    From : <input type="date" name="startDate" v-model="form.startDate" class="rounded">
                                </div>
                                <div class="ml-4 font-medium">
                                    To : <input type="date" name="endDate" v-model="form.endDate" class="rounded">
                                </div>
                                <div class="ml-12 ">
                                    <button
                                        class="text-white bg-cyan-600 border-0 py-2 px-6 focus:outline-none hover:bg-cyan-700 rounded text-lg font-medium">
                                        分析する</button>
                                </div>
                            </div>
                        </form>

                        <div v-show="data.data">
                            <Chart :data="data" />
                        </div>

                        <div v-show="data.data" class="lg:w-2/3 mx-auto overflow-auto flex justify-center mt-12">
                            <table class="table-auto w-3/4 text-left whitespace-no-wrap">
                                <thead>
                                    <tr class="text-justify divide-x">
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                            日付</th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            売上</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data.data" :key="item.date" class="divide-x tabular-nums">
                                        <td class="border-b-2 border-gray-200 px-4 py-3">
                                            {{ dayjs(item.date).format('YYYY/MM/DD(ddd)') }}</td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3">{{ item.total }}円</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

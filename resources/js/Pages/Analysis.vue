<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import { getToday } from '@/common';
import axios from 'axios';
import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';
// import dayjs from 'dayjs';
// import 'dayjs/locale/ja';

// dayjs.locale('ja');

onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay',
    rfmPrms: [
        14, 28, 60, 90, 7, 5, 3, 2, 300000, 200000, 100000, 30000
    ],
})

const data = reactive({})

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
                rfmPrms: form.rfmPrms,
            }
        })
            .then(res => {
                data.data = res.data.data
                if (res.data.labels) { data.labels = res.data.labels }
                if (res.data.eachCount) { data.eachCount = res.data.eachCount }
                data.totals = res.data.totals
                data.type = res.data.type
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
                    <div class="md:p-6 text-gray-800">

                        <form @submit.prevent="getData">
                            <div class="p-6">
                                <div class="w-1/12 text-center font-medium border-b-2 mb-6">
                                    分析方法</div>
                                <div class=" md:flex md:space-x-6 pl-6">
                                    <div>
                                        <input type="radio" v-model="form.type" value="perDay" checked
                                            class="w-4 h-4 text-slate-400 bg-slate-100 border-gray-300 focus:ring-slate-400 focus:ring-1">
                                        <span class="px-2">日別</span>
                                    </div>
                                    <div>
                                        <input type="radio" v-model="form.type" value="perMonth"
                                            class="w-4 h-4 text-slate-400 bg-slate-100 border-gray-300 focus:ring-slate-400 focus:ring-1">
                                        <span class="px-2">月別</span>
                                    </div>
                                    <div>
                                        <input type="radio" v-model="form.type" value="perYear"
                                            class="w-4 h-4 text-slate-400 bg-slate-100 border-gray-300 focus:ring-slate-400 focus:ring-1">
                                        <span class="px-2">年別</span>
                                    </div>
                                    <div>
                                        <input type="radio" v-model="form.type" value="decile"
                                            class="w-4 h-4 text-slate-400 bg-slate-100 border-gray-300 focus:ring-slate-400 focus:ring-1">
                                        <span class="px-2">デシル分析</span>
                                    </div>
                                    <div>
                                        <input type="radio" v-model="form.type" value="rfm"
                                            class="w-4 h-4 text-slate-400 bg-slate-100 border-gray-300 focus:ring-slate-400 focus:ring-1">
                                        <span class="px-2">RFM分析</span>
                                    </div>
                                </div>
                            </div>

                            <div class="md:flex p-6">
                                <div class="font-medium italic">
                                    From : <input type="date" name="startDate" v-model="form.startDate"
                                        class="rounded-md  bg-gray-100 bg-opacity-50 border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-4 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <div class="ml-4 font-medium italic">
                                    To : <input type="date" name="endDate" v-model="form.endDate"
                                        class="rounded-md  bg-gray-100 bg-opacity-50 border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-4 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <div class="ml-8">
                                    <button
                                        class="text-white bg-slate-400 border-0 py-2 px-4 focus:outline-none hover:bg-slate-500 rounded-md font-medium">
                                        分析する</button>
                                </div>
                            </div>

                            <div v-if="form.type === 'rfm'" class="py-4">
                                <table class="mx-auto border-separate border-spacing-4">
                                    <thead class="text-left text-gray-700">
                                        <tr>
                                            <th class="border-b">ランク</th>
                                            <th class="border-b">最新購入日(Recency)</th>
                                            <th class="border-b">購入回数(Frequency)</th>
                                            <th class="border-b">購入金額合計(Monetary)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[0]"> 日以内</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[4]"> 回以上</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-32 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[8]"> 円以上</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[1]"> 日以内</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[5]"> 回以上</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-32 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[9]"> 円以上</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[2]"> 日以内</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[6]"> 回以上</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-32 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[10]"> 円以上</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[3]"> 日以内</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-24 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[7]"> 回以上</td>
                                            <td><input type="number"
                                                    class="box-border h-6 w-32 p-4  border rounded bg-opacity-50 border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out bg-gray-100"
                                                    v-model="form.rfmPrms[11]"> 円以上</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div v-show="data.data">
                            <div v-if="data.type != 'rfm'">
                                <Chart :data="data" />
                            </div>
                            <ResultTable :data="data" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

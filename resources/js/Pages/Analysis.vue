<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import { getToday } from '@/common';
import axios from 'axios';
import Chart from '@/Components/Chart.vue';
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
                        </form>

                        <div v-show="data.data">
                            <Chart :data="data" />
                        </div>

                        <div v-show="data.data" class="lg:w-3/4 mx-auto overflow-auto flex justify-center mt-6">
                            <table class="table-auto w-3/4 text-left whitespace-no-wrap">
                                <thead>
                                    <tr class="text-justify">
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                            年月日</th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            売上</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data.data" :key="item.date" class="tabular-nums">
                                        <td class="border-b-2 border-gray-200 px-4 py-3">
                                            {{ (item.date) }}</td>
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
    errors: Object
})

const form = reactive({
    name: null,
    kana: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    memo: null,
})

const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
        form.address = value.region + value.locality + value.street
    });
}

const storeCustomer = () => {
    router.post('/customers', form)
}

</script>

<template>
    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客登録</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeCustomer">

                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                                    <input type="text" id="name" name="name" v-model="form.name"
                                                        placeholder="例) 山田 太郎"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.name" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                                                    <input type="text" id="kana" name="kana" v-model="form.kana"
                                                        placeholder="例) ヤマダ タロウ"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.kana" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                                    <input type="tel" id="tel" name="tel" v-model="form.tel"
                                                        placeholder="例) 09012345678"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.tel" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="email"
                                                        class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                                    <input type="email" id="email" name="email" v-model="form.email"
                                                        placeholder="例) xxx@exanple.com"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.email" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="postcode"
                                                        class="leading-7 text-sm text-gray-600">郵便番号</label>
                                                    <input type="number" id="postcode" name="postcode"
                                                        @change="fetchAddress" v-model="form.postcode"
                                                        placeholder="例) 1000001"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.postcode" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                                    <input type="text" id="address" name="address" v-model="form.address"
                                                        placeholder="例) 東京都千代田区千代田12345"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.address" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="birthday"
                                                        class="leading-7 text-sm text-gray-600">生年月日</label>
                                                    <input type="date" id="birthday" name="birthday" v-model="form.birthday"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <InputError class="mb-2" :message="errors.birthday" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <label for="gender" class="leading-7 text-sm text-gray-600">
                                                    性別
                                                </label>
                                                <div class="relative flex justify-around">
                                                    <div>
                                                        <input type="radio" id="male" name="gender" v-model="form.gender"
                                                            value="0"
                                                            class="w-4 h-4 mr-2 text-slate-600 bg-gray-100 border-gray-300 focus:ring-slate-500 dark:focus:ring-slate-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="male">男性</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="female" name="gender" v-model="form.gender"
                                                            value="1"
                                                            class="w-4 h-4 mr-2 text-slate-600 bg-gray-100 border-gray-300 focus:ring-slate-500 dark:focus:ring-slate-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="female">女性</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="other" name="gender" v-model="form.gender"
                                                            value="2"
                                                            class="w-4 h-4 mr-2 text-slate-600 bg-gray-100 border-gray-300 focus:ring-slate-500 dark:focus:ring-slate-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="other">その他</label>
                                                    </div>
                                                </div>
                                                <InputError class="mb-2" :message="errors.gender" />
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                    <textarea id="memo" name="memo" v-model="form.memo"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-slate-500 border-0 py-2 px-8 focus:outline-none hover:bg-slate-600 rounded text-lg">
                                                    登録する</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
</script>

<template>
    <div v-if="$page.props.flash.status === 'success'" class="lg:w-2/3 mx-auto bg-blue-300 text-white p-4 rounded">
        {{ $page.props.flash.message }}
    </div>
    <div v-if="$page.props.flash.status === 'danger'" class="lg:w-2/3 mx-auto bg-red-300 text-white p-4 rounded">
        {{ $page.props.flash.message }}
    </div>
</template>

<script setup>
</script>

<template>
    <div v-if="$page.props.flash.status === 'success'"
        class="lg:w-1/3 mx-auto text-center bg-sky-800 text-white p-2 rounded">
        {{ $page.props.flash.message }}
    </div>
    <div v-if="$page.props.flash.status === 'danger'" class="lg:w-1/3 mx-auto bg-red-800 text-white p-2 rounded">
        {{ $page.props.flash.message }}
    </div>
</template>

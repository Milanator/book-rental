<script setup>
import { useListing } from "@/composables/useListing";

const { resetFilter } = useListing();
</script>
<template>
    <div class="col-sm">
        <button type="button" class="btn btn-danger" @click="resetFilter">
            Reset filtra
        </button>
    </div>
</template>

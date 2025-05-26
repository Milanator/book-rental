<script setup>
import { useListing } from "@/composables/useListing";
import ResetFilter from "@/components/listing/ResetFilter.vue";

const { changeFilterField } = useListing();
</script>
<template>
    <div id="filter" class="row my-2">
        <div class="col-sm">
            <!-- Title -->
            <input
                class="form-control"
                type="text"
                name="name"
                placeholder="Meno"
                @input="changeFilterField"
            />
        </div>
        <div class="col-sm">
            <!-- Author -->
            <input
                class="form-control"
                type="text"
                name="surname"
                placeholder="Priezvisko"
                @input="changeFilterField"
            />
        </div>
        <ResetFilter />
    </div>
</template>

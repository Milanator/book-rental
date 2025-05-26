<script setup>
import { useListing } from "@/composables/useListing";

const { changeFilterField, resetFilter } = useListing();
</script>
<template>
    <div id="filter" class="row my-2">
        <div class="col-sm">
            <!-- Title -->
            <input
                class="form-control"
                type="text"
                name="title"
                placeholder="Názov"
                @input="changeFilterField"
            />
        </div>
        <div class="col-sm">
            <!-- Author -->
            <input
                class="form-control"
                type="text"
                name="author"
                placeholder="Autor"
                @input="changeFilterField"
            />
        </div>
        <div class="col-sm">
            <!-- Borrowed -->
            <select
                class="form-control"
                name="is_borrowed"
                @change="changeFilterField"
            >
                <option value="">Všetky</option>
                <option value="1">Požičané</option>
                <option value="0">Nepožičané</option>
            </select>
        </div>
        <div class="col-sm">
            <button type="button" class="btn btn-danger" @click="resetFilter">
                Reset filtra
            </button>
        </div>
    </div>
</template>

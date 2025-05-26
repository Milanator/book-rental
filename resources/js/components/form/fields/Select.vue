<script setup>
const props = defineProps(["field"]);
</script>
<template>
    <div class="mb-3">
        <!-- Label -->
        <label :for="field.name" class="form-label">{{ field.label }}</label>
        <!-- Field -->
        <select
            class="form-select"
            :id="field.name"
            :name="field.name"
            :required="field.required"
        >
            <option
                v-for="(label, value) in field.options"
                :key="value"
                :value="value"
            >
                {{ label }}
            </option>
        </select>
    </div>
</template>

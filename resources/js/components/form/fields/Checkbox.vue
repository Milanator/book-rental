<script setup>
const props = defineProps(["field"]);
</script>
<template>
    <div class="form-check">
        <!-- Field -->
        <input
            class="form-check-input"
            type="checkbox"
            :id="field.name"
            :name="field.name"
            :placeholder="field.placeholder"
            :required="field.required"
        />
        <!-- Label -->
        <label class="form-check-label" :for="field.name">
            {{ field.label }}
        </label>
    </div>
</template>

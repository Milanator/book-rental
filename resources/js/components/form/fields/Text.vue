<script setup>
const props = defineProps(["field"]);
</script>
<template>
    <div class="form-group mb-3">
        <!-- Label -->
        <label :for="field.name">{{ field.label }}</label>
        <!-- Field -->
        <input
            type="text"
            class="form-control"
            :id="field.name"
            :name="field.name"
            :placeholder="field.placeholder"
            :required="field.required"
        />
    </div>
</template>

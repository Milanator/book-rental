<script setup>
const props = defineProps(["field"]);
</script>
<template>
    <div class="form-group">
        <label :for="field.name">{{ field.label }}</label>
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

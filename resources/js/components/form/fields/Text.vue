<script setup>
import { useForm } from "@/composables/useForm";

const props = defineProps(["field"]);

const { getFieldValue } = useForm();

const value = getFieldValue(props.field.name);
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
            v-model="value"
        />
    </div>
</template>

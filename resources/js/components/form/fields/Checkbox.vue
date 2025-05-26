<script setup>
import { useForm } from "@/composables/useForm";

const props = defineProps(["field"]);

const { getFieldValue } = useForm();

const value = getFieldValue(props.field.name);
</script>
<template>
    <div class="form-check mb-3">
        <!-- Field -->
        <input
            class="form-check-input"
            type="checkbox"
            :id="field.name"
            :name="field.name"
            :placeholder="field.placeholder"
            :required="field.required"
            v-model="value"
        />
        <!-- Label -->
        <label class="form-check-label" :for="field.name">
            {{ field.label }}
        </label>
    </div>
</template>

<script setup>
import { useForm } from "@/composables/useForm";

const props = defineProps(["field"]);

const { getFieldValue } = useForm();

const value = getFieldValue(props.field.name);
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
            v-model="value"
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

<template>
    <div class="form-group">
        <label :for="id">
            <slot />
        </label>
        <textarea :id="id" class="form-control" :rows="rows" :placeholder="placeholder" :value="modelValue"
            @input="$emit('input:modelValue', $event.target.value)"></textarea>
    </div>
</template>

<script>
export default {
    name: "ArgonTextarea",
    emits: ['input:modelValue'],
    props: {
        id: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            default: "",
        },
        rows: {
            type: Number,
            default: 5,
        },
        modelValue: {
            type: [String, Number],
            default: "",
        },
    },
};
</script>

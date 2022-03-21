<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label">{{ label }}:</label>
    <v-select v-model="selected" :options="options" :value="value" class="form-select" :class="{ error: error }" />
  </div>
  <div v-if="error" class="form-error">{{ error }}</div>
</template>

<script>
import {v4 as uuid} from 'uuid'

export default {
  name: 'VSelect',
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${uuid()}`
      },
    },
    error: String,
    label: String,
    value: [String, Number, Boolean],
    modelValue: [String, Number, Boolean],
  },
  emits: ['update:modelValue'],
  data() {
    return {
      options: [],
      selected: this.modelValue,
    }
  },

  watch: {
    selected(selected) {
      this.$emit('update:modelValue', selected)
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>

<style scoped>

</style>
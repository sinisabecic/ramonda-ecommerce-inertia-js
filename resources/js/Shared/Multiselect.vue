<template>
<!--  <form>-->
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :id="id">{{ label }}:</label>
    <multiselect id="id" taggable multiple push-tags
                 :options="options"
                 v-bind="{ ...$attrs, class: null }"
                 class="form-input" :class="{ error: error }" style="z-index: 9999"
    ></multiselect>
  </div>
<!--  </form>-->
</template>

<script>
import Multiselect from '@suadelabs/vue3-multiselect'
import {v4 as uuid} from 'uuid'

export default {
  components: {Multiselect},

  props: {
    id: {
      type: String,
      default() {
        return `text-input-${uuid()}`
      },
    },
    error: String,
    label: String,
    options: Array,
  },

}
</script>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

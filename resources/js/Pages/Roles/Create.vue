<template>
  <div>
    <Head title="Create Role" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/roles">Roles</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-7xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Role name" />
          <multiselect v-model="form.permissions" :options="permissions" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Select permission(s)" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Role</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import Multiselect from '@/Shared/Multiselect'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    TextInput,
    Multiselect,
  },
  layout: Layout,
  remember: 'form',

  props: {
    permissions: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        permissions: '',
      }),
    }
  },

  methods: {
    store() {
      this.form.post('/admin/roles', {
        onSuccess: () => this.form.reset('name', 'permissions')
      })
    },
  },
}
</script>
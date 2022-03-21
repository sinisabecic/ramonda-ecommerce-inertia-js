<template>
  <div>
    <Head :title="`${form.name}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/roles">Roles</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.name }}
      </h1>
    </div>
    <div class="max-w-7xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Role name" />
          <multiselect v-model="form.permissions" :options="all_permissions" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Select permission(s)" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete role</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update role</loading-button>
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
import TrashedMessage from '@/Shared/TrashedMessage'
import Multiselect from '@/Shared/Multiselect'

export default {
  components: {
    Multiselect,
    Head,
    Link,
    LoadingButton,
    TextInput,
  },
  layout: Layout,
  props: {
    role: Object,
    all_permissions: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        name: this.role.name,
        permissions: this.role.permissions
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/roles/${this.role.id}`, {
        onSuccess: () => this.form.reset('name',),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this role?')) {
        this.$inertia.delete(`/admin/roles/${this.role.id}`)
      }
    },
  },
}
</script>

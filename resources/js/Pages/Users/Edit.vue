<template>
  <div>
    <Head :title="`${form.first_name} ${form.last_name}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/users">Users</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.first_name }} {{ form.last_name }}
      </h1>
      <img v-for="img in user.photo" v-if="user.photo" class="block ml-4 w-8 h-8 rounded-full" :src="`${user.avatarPath}/${user.id}/${img.url}`" />
    </div>
    <trashed-message v-if="user.deleted_at" class="mb-6" @restore="restore"> This user has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pb-8 pr-6 w-full lg:w-1/2" label="First name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Last name" />
          <text-input v-model="form.username" :error="form.errors.username" class="pb-8 pr-6 w-full lg:w-1/2" label="Username" />
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
          <select-input v-model="form.role_name" :error="form.errors.role_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Role">
            <option :value="user.role_name">{{ user.role_name }}</option>
            <option v-for="role in other_roles" :key="role.id" :value="role.name">{{ role.name }}</option>
          </select-input>
          <select-input v-model="form.country_id" :error="form.errors.country" class="pb-8 pr-6 w-full lg:w-1/2" label="Country">
            <option :value="user.country_id">{{ user.country.name }}</option>
            <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.name }}</option>
          </select-input>
          <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
        </div>

        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete user</button>
          <button class="text-indigo-600 font-bold hover:underline ml-2.5" tabindex="-1" type="button" @click="remove">Remove user</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update User</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import FileInput from '@/Shared/FileInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    FileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    user: Object,
    countries: Array,
    other_roles: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        username: this.user.username,
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        password: '',
        user_roles: this.user.user_roles,
        role_id: this.user.role_id,
        role_name: this.user.role_name,
        photo: null,
        country: this.user.country,
        country_id: this.user.country_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/users/${this.user.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete(`/admin/users/${this.user.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this user?')) {
        this.$inertia.put(`/admin/users/${this.user.id}/restore`)
      }
    },
    remove() {
      if (confirm('Are you sure you want to restore this user?')) {
        this.$inertia.delete(`/admin/users/${this.user.id}/remove`)
      }
    },
  },
}
</script>

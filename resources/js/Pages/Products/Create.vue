<template>
  <div>
    <Head title="Create User" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/products">Products</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-7xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Product name" />
<!--          <text-input v-model="form.slug" :error="form.errors.slug" class="pb-8 pr-6 w-full lg:w-1/2" label="Slug" />-->
          <text-input v-model="form.details" :error="form.errors.details" class="pb-8 pr-6 w-full lg:w-1/2" label="Details" />
          <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full lg:w-1/2" label="Price" />
          <text-input v-model="form.quantity" :error="form.errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2" type="number" label="Quantity" />
          <editor v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
          <select-input v-model="form.featured" :error="form.errors.featured" class="pt-8 pb-8 pr-6 w-full lg:w-1/2" label="Featured">
            <option :value="true">Yes</option>
            <option :value="false">No</option>
          </select-input>
          <select-input v-model="form.categories" :error="form.errors.categories" class="pt-8 pb-8 pr-6 w-full lg:w-1/2" label="Category">
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select-input>
          <file-input v-model="form.image" :error="form.errors.image" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Image" />
          <multiple-file-input v-model="form.images" :error="form.errors.images" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Multiple Images" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Product</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import FileInput from '@/Shared/FileInput'
import MultipleFileInput from '@/Shared/MultipleFileInput'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import Editor from '@/Shared/Editor'

export default {
  components: {
    FileInput,
    MultipleFileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    Editor,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        details: '',
        description: '',
        price: '',
        quantity: '',
        featured: 0,
        categories: '',
        image: null,
        images: null,
        // slug: '',
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/admin/products')
    },
  },

  props: {
    categories: Array
  }
}
</script>
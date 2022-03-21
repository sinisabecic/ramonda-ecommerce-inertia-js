<template>
  <div>
    <Head :title="`${form.name}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/products">Products</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.name }}
      </h1>
      <img v-if="product.image" class="block ml-4 w-8 h-8 rounded-full" :src="`${product.image}`" />
    </div>
    <trashed-message v-if="product.deleted_at" class="mb-6" @restore="restore"> This product has been deleted. </trashed-message>
    <div class="max-w-7xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Product name" />
          <text-input v-model="form.details" :error="form.errors.details" class="pb-8 pr-6 w-full lg:w-1/2" label="Details" />
          <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full lg:w-1/2" label="Price" />
          <text-input v-model="form.quantity" :error="form.errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2" type="number" label="Quantity" />
          <editor v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description">{{product.description}}</editor>
          <select-input v-model="form.featured" :error="form.errors.featured" class="pt-8 pb-8 pr-6 w-full lg:w-1/2" label="Featured">
            <option :value="1">Yes</option>
            <option :value="0">No</option>
          </select-input>

          <select-input v-model="form.category_id" :error="form.errors.category_id" class="pt-8 pb-8 pr-6 w-full lg:w-1/2" label="Select category">
<!--            <option :value="form.category_id">{{ form.category_name }}</option>-->
            <option :value="product.category_id">{{ product.category_name }}</option>
            <option v-for="c in other_categories" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select-input>


<!--          <multiselect v-model="form.categories" :options="all_categories" :error="form.errors.categories" class="pt-8 pb-8 pr-6 w-full lg:w-1/2"-->
<!--                       label="Select category(s)" />-->


          <file-input v-model="form.image" :error="form.errors.image" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Image" />
          <multiple-file-input v-model="form.images" :error="form.errors.images" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Multiple Images" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!product.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete product</button>
          <button class="text-indigo-600 font-bold hover:underline ml-2.5" tabindex="-1" type="button" @click="remove">Remove product</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update product</loading-button>
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
import Multiselect from '@/Shared/Multiselect'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import Editor from '@/Shared/Editor'
import MultipleFileInput from '@/Shared/MultipleFileInput'

export default {
  components: {
    FileInput,
    MultipleFileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    Multiselect,
    TextInput,
    Editor,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    product: Object,
    other_categories: Array,
    all_categories: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        name: this.product.name,
        details: this.product.details,
        description: this.product.description,
        price: this.product.price,
        quantity: this.product.quantity,
        featured: this.product.featured,
        // categories: this.product.categories,
        // category_name: this.product.category_name,
        category_id: this.product.category_id,
        image: null,
        images: null,
      }),


    }
  },
  methods: {
    update() {
      this.form.post(`/admin/products/${this.product.id}`, {
        onSuccess: () => this.form.reset('image', 'images'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this product?')) {
        this.$inertia.delete(`/admin/products/${this.product.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this product?')) {
        this.$inertia.put(`/admin/products/${this.product.id}/restore`)
      }
    },
    remove() {
      if (confirm('Are you sure you want to remove this product?')) {
        this.$inertia.delete(`/admin/products/${this.product.id}/remove`)
      }
    },
  },
}
</script>

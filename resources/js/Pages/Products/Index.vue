<template>
  <div>
    <Head title="Products" />
    <h1 class="mb-8 text-3xl font-bold">Products</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Featured:</label>
        <select v-model="form.featured" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="true">Featured</option>
          <option value="false">Not Featured</option>
        </select>
        <label class="block mt-4 text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <div class="flex justify-end">
        <Link class="btn-indigo" href="/admin/products">
          <span>Refresh</span>
          <span class="hidden md:inline">&nbsp;list</span>
        </Link>
        <Link class="btn-indigo ml-1.5" href="/admin/products/create">
          <span>Create</span>
          <span class="hidden md:inline">&nbsp;product</span>
        </Link>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Price</th>
          <th class="pb-4 pt-6 px-6">Featured</th>
          <th class="pb-4 pt-6 px-6">Quantity</th>
          <th class="pb-4 pt-6 px-6">Created</th>
        </tr>
        <tr v-for="product in products" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${product.id}/edit`">
              <img v-if="product.image" class="block -my-2 mr-2 w-10" :src="`${product.image}`" />
              <h1 class="text-sm font-bold">{{ product.name }}</h1>
              <icon v-if="product.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-red-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${product.id}/edit`">
              <h1 class="text-sm font-semibold">{{ product.price }} &euro;</h1>
            </Link>
          </td>
          <td class="border-t">
            <Link v-if="product.featured === 1" class="flex items-center px-6 py-4" :href="`/admin/products/${product.id}/edit`" tabindex="-1">
              <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">
                featured
              </span>
            </Link>
            <Link v-if="product.featured === 0" class="flex items-center px-6 py-4" :href="`/admin/products/${product.id}/edit`" tabindex="-1">
              <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900">
                not featured
              </span>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/admin/products/${product.id}/edit`" tabindex="-1">
              {{ product.quantity }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/admin/products/${product.id}/edit`" tabindex="-1">
              {{ product.created_at }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/admin/users/${product.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>

        <tr v-if="products.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No products found.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    products: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        featured: this.filters.featured,
      },
    }
  },

  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/admin/products', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>

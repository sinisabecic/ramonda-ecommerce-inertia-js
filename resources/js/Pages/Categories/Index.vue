<template>
  <div>
    <Head title="Categories" />
    <h1 class="mb-8 text-3xl font-bold">Categories</h1>
    <div class="flex items-center justify-between mb-6">
      <search v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      </search>
      <div class="flex justify-end">
        <Link class="btn-indigo" href="/admin/categories/create">
          <span>Create</span>
          <span class="hidden md:inline">&nbsp;category</span>
        </Link>
        <Link class="btn-indigo ml-1.5" href="/admin/categories">
          <span>Refresh</span>
          <span class="hidden md:inline">&nbsp;list</span>
        </Link>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Slug</th>
          <th class="pb-4 pt-6 px-6">Created</th>
        </tr>
        <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/categories/${category.id}/edit`">
              <h1 class="text-sm font-bold">{{ category.name }}</h1>
              <icon v-if="category.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-red-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/categories/${category.id}/edit`">
              <h1 class="text-sm font-semibold">{{ category.slug }}</h1>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/admin/categories/${category.id}/edit`" tabindex="-1">
              {{ category.created_at }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/admin/categories/${category.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>

        <tr v-if="categories.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No categories found.</td>
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
import Search from '@/Shared/Search'

export default {
  components: {
    Head,
    Icon,
    Link,
    Search,
  },
  layout: Layout,
  props: {
    filters: Object,
    categories: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },

  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/admin/categories', pickBy(this.form), { preserveState: true })
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

<template>
  <div>
    <Head title="Roles" />
    <h1 class="mb-8 text-3xl font-bold">Roles</h1>
    <div class="flex items-center justify-between mb-6">
      <search v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      </search>
      <div class="flex justify-end">
      <Link class="btn-indigo" href="/admin/permissions">
        <span>Permissions</span>
        <span class="hidden md:inline">&nbsp;list</span>
      </Link>
      <Link class="btn-indigo ml-1.5" href="/admin/roles/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;role</span>
      </Link>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Guard name</th>
          <th class="pb-4 pt-6 px-6">Created</th>
        </tr>
        <tr v-for="role in roles" :key="role.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/roles/${role.id}/edit`">
              <h1 class="text-sm font-bold">{{ role.name }}</h1>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/roles/${role.id}/edit`">
              <h1 class="text-sm font-semibold">{{ role.guard_name }}</h1>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/admin/roles/${role.id}/edit`" tabindex="-1">
              {{ role.created_at }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/admin/roles/${role.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>

        <tr v-if="roles.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No roles found.</td>
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
    roles: Array,
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
        this.$inertia.get('/admin/roles', pickBy(this.form), { preserveState: true })
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

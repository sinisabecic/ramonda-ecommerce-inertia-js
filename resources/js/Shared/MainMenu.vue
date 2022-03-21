<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('/') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin/users">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('users') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('users') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Users</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin/roles">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('roles') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('roles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Roles</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin/permissions">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('permissions') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('permissions') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Permissions</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin/products">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('products') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('products') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Products</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin/categories">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('categories') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('categories') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Categories</div>
      </Link>
    </div>
<!--    <div class="mb-4">-->
<!--      <Link class="group flex items-center py-3" href="/primatech/clients">-->
<!--        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('primatech') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--        <div :class="isUrl('primatech') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Clients</div>-->
<!--      </Link>-->
<!--    </div>-->
<!--    <div class="mb-4">-->
<!--      <Link class="group flex items-center py-3" href="/admin/organizations">-->
<!--        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Organizations</div>-->
<!--      </Link>-->
<!--    </div>-->
<!--    <div class="mb-4">-->
<!--      <Link class="group flex items-center py-3" href="/admin/contacts">-->
<!--        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>-->
<!--      </Link>-->
<!--    </div>-->
<!--    <div class="mb-4">-->
<!--      <Link class="group flex items-center py-3" href="/admin/reports">-->
<!--        <icon name="printer" class="mr-2 w-4 h-4" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>-->
<!--      </Link>-->
<!--    </div>-->
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>

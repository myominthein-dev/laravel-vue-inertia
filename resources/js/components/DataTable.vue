<template>
  <div class="w-full">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-300 mb-2">{{ firstLetterToUpperCase(name) }} Table</h2>
      <p class="text-gray-200">Manage your {{ name }} entries</p>
    </div>
    
    <!-- Search and Filter Bar -->
    <div class="mb-4 flex flex-col sm:flex-row gap-4">
      <div class="relative flex-1">
        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" />
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search by title or description..."
          class="w-full pl-10 pr-4 py-2 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        />
      </div>
      <Link :href="route(name + '.create')"
        
        class="px-4 py-2  bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2"
      >
        <Plus class="h-4 w-4" />
        Add {{ firstLetterToUpperCase(name) }}
      </Link>
    </div>

    <!-- Table -->
    <div class= "rounded-lg border border-gray-600 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr>
              <th :key="th" v-for="th in tableHeads" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                {{ th }}
              </th>
             
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class=" divide-y divide-gray-700">
            <tr v-for="item in filteredData" :key="item.id" class="hover:bg-gray-500">
              <td v-if="item.title || item.name" class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-300">{{ item.title ? item.title : item.name }}</div>
              </td>
              <td v-if="item.description" class="px-6 py-4">
                <div class="text-sm text-gray-300 max-w-xs truncate" :title="item.description">
                  {{ item.description }}
                </div>
              </td>
              <td v-if="item.slug" class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  {{ item.slug }}
                </span>
              </td>
             
              <td v-if="item.category_id" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                {{ item.category.name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center gap-2">
                  <Link :href="route(name + '.' + 'edit',{ [name]: item.id })"
                    
                    class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-500"
                  >
                    <Edit2 class="h-4 w-4" />
                  </Link>
                  <button v-if="can('delete-courses')" @click="deleteItem(item.id)"
                    
                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-500"
                  >
                    <Trash2 class="h-4 w-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <!-- Empty State -->
      <div v-if="filteredData.length === 0" class="text-center py-12">
        <div class="text-gray-200 mb-2">No data found</div>
        <p class="text-sm text-gray-400">Try adjusting your search or add a new entry</p>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex items-center justify-between">
      <div class="text-sm text-gray-100">
        Showing {{ Math.min((currentPage - 1) * itemsPerPage + 1, filteredData.length) }} to 
        {{ Math.min(currentPage * itemsPerPage, filteredData.length) }} of {{ filteredData.length }} results
      </div>
      <div class="flex items-center gap-2">
        <button
          @click="currentPage--"
          :disabled="currentPage === 1"
          class="px-3 py-1 border border-gray-700 rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-500"
        >
          <ChevronLeft class="h-4 w-4" />
        </button>
        <span class="px-3 py-1 text-sm">{{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="currentPage++"
          :disabled="currentPage === totalPages"
          class="px-3 py-1 border border-gray-700 rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-500"
        >
          <ChevronRight class="h-4 w-4" />
        </button>
      </div>
    </div>

    
  </div>
</template>

<script setup>
import { ref, computed, reactive, onMounted } from 'vue'
import { Search, Plus, Edit2, Trash2, ChevronLeft, ChevronRight } from 'lucide-vue-next'
import { Link, router, useForm, usePage } from '@inertiajs/vue3'

 const props = defineProps(["name", "tableHeads","tableData"])
 const form = useForm();
 
 const page = usePage()
 const permissions = page.props.auth.permissions
 
 const can = (perm) => {
    return permissions.includes(perm)
 }

 
// Sample data

const sampleData = ref(props.tableData)

const firstLetterToUpperCase  = (str) => {
  return str.charAt(0).toUpperCase() + str.slice(1)
}

// Search and filtering
const searchQuery = ref('')
const filteredData = computed(() => {
  if (!searchQuery.value) return sampleData.value
  return sampleData.value.filter(item =>
    item.title?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.description?.toLowerCase().includes(searchQuery.value.toLowerCase()) || item.name?.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

// Pagination
const currentPage = ref(1)
const itemsPerPage = ref(10)
const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage.value))



// Form data
const formData = reactive({
  title: '',
  description: '',
  slug: '',
  user_id: '',
  category_id: ''
})

// Reset form
const resetForm = () => {
  formData.title = ''
  formData.description = ''
  formData.slug = ''
  formData.user_id = ''
  formData.category_id = ''
}

// Delete item
const deleteItem = (id) => {
  const oldData = [...sampleData.value]
  router.delete(route(props.name + '.destroy', id), {
    preserveScroll: true, // Keep scroll position
    onSuccess : () => {
      sampleData.value = sampleData.value.filter(s => s.id != id)
    },
    onError: () => {
      sampleData.value = oldData
    }
  })
}


</script>


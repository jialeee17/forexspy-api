<template>
  <nav aria-label="breadcrumb">
    <ol class="px-0 pt-1 pb-0 mb-0 bg-transparent breadcrumb me-sm-6">
      <!-- <li :class="`text-sm breadcrumb-item`">
        <a :class="isNavFixed ? 'text-dark' : 'text-white'">
          <i class="ni ni-box-2"></i>
        </a>
      </li> -->
      <li class="text-sm breadcrumb-item text-white" v-if="currentPage != 'Dashboard'">
        <a class="text-white" href="#">{{ currentDirectory }}</a>
      </li>
      <li class="text-sm breadcrumb-item active text-white" aria-current="page">
        {{ currentPage }}
      </li>
    </ol>
    <h6 class="mb-0 font-weight-bolder text-white">
      {{ currentPage }}
    </h6>
  </nav>
</template>

<script>
export default {
  name: "Breadcrumbs",
  props: {
    currentPage: {
      type: String,
      default: ""
    },
    currentDirectory: {
      type: String,
      default: ""
    }
  },
};
</script>

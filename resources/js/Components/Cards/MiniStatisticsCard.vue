<template>
  <div class="mb-3 card slide-up-on-hover">
    <div class="p-3 card-body">
      <div class="d-flex" :class="rowReverse ? '' : 'flex-row-reverse justify-content-between'">
        <div class="text-center shadow icon icon-shape" :class="[
          typeof icon === 'object'
            ? `${icon.background} ${icon.shape}`
            : 'border-radius-md',
          rowReverse ? 'me-2' : '',
        ]">
          <i class="text-lg opacity-10" :class="typeof icon === 'string' ? icon : icon.component" aria-hidden="true"></i>
        </div>
        <div :class="classContent">
          <div class="numbers">
            <p class="mb-0 text-sm text-uppercase fw-bold" :class="title.color">
              {{ typeof title === "string" ? title : title.text }}
            </p>
            <h5 :class="`mb-0 fw-bolder ${value.color}`">
              {{
                (value && typeof value === "string") ||
                (value && typeof value === "number")
                ? value
                : value.text
              }}
              <span v-if="percentage && typeof percentage === 'string'" class="text-sm fw-bolder">
                {{ percentage }}
              </span>
              <span v-if="percentage && typeof percentage === 'object'"
                :class="`text-sm fw-bolder text-${percentage.color}`">
                {{ percentage.value }}
              </span>
            </h5>
            <p class="mt-2 mb-0"><span class="mt-2 mb-0 text-sm fw-bolder"
                :class="$filters.percentage_colour(percentage)">{{ $filters.percentage(percentage) }}</span> since starting</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MiniStatisticsCard",
  props: {
    rowReverse: {
      type: Boolean,
      default: false,
    },
    title: {
      type: [Object, String],
      required: true,
      text: {
        type: String,
      },
      color: {
        type: String,
      },
    },
    description: {
      type: String,
      default: "",
    },
    value: {
      type: [Object, String, Number],
      required: true,
      text: {
        type: [String, Number],
      },
      color: {
        type: String,
      },
    },
    percentage: {
      type: Number,
      default: 0,
    },
    icon: {
      type: [String, Object],
      component: {
        type: String,
      },
      background: {
        type: String,
      },
      shape: {
        type: String,
      },
      default: () => ({
        background: "bg-white",
        shape: " border-radius-md",
      }),
    },
    classContent: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.text-success {
  color: #2dce89 !important;
}
</style>

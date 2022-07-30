<template>
  <DispOpeningStock :key="rerender" />
  <AddOpeningStock @rerender-table="rerenderTable" />
</template>

<script>
import AddOpeningStock from "src/components/AddOpeningStock.vue";
import DispOpeningStock from "components/DispOpeningStock.vue";

export default {
  name: "OpeningStock",

  data() {
    return {
      rerender: 0,
    };
  },

  components: {
    AddOpeningStock,
    DispOpeningStock,
  },

  methods: {
    rerenderTable() {
      this.rerender += 1;
    },
  },
};
</script>

<template>
  <DispStockIn :key="rerender" />
  <AddStockIn @rerender-table="rerenderTable" />
</template>

<script>
import DispStockIn from "components/DispStockIn.vue";
import AddStockIn from "components/AddStockIn.vue";

export default {
  name: "StockIn",

  data() {
    return {
      rerender: 0,
    };
  },

  components: {
    DispStockIn,
    AddStockIn,
  },

  methods: {
    rerenderTable() {
      this.rerender += 1;
    },
  },
};
</script>

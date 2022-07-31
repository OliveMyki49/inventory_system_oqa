<template>
  <DispStockOut :key="rerender" />
  <AddStockOut @rerender-table="rerenderTable" />
</template>

<script>
import DispStockOut from "components/DispStockOut.vue";
import AddStockOut from "components/AddStockOut.vue";

export default {
  name: "StockOut",

  data() {
    return {
      rerender: 0,
    };
  },

  components: {
    DispStockOut,
    AddStockOut,
  },

  methods: {
    rerenderTable() {
      this.rerender += 1;
    },
  },
};
</script>

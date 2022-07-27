<template>
  <AddStockIn />
  <DispOpeningStock />
</template>

<script>
import AddStockIn from "components/AddStockIn.vue";
import DispOpeningStock from "components/DispOpeningStock.vue";

export default {
  name: "OpeningStock",
  setup() {},

  components: {
    AddStockIn,
    DispOpeningStock,
  },
};
</script>

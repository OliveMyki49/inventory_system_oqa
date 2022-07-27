<template>
  <div class="q-pa-md">
    <q-table
      title="Opening Stock"
      :loading="loading"
      :rows="rows"
      :columns="columns"
      row-key="name"
      :filter="filter"
      binary-state-sort
    >
      <template v-slot:top-right>
        <q-input
          borderless
          dense
          debounce="300"
          v-model="filter"
          placeholder="Search"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="op_id" :props="props"> {{ props.row.op_id }}</q-td>
          <q-td key="item_code" :props="props"> {{ props.row.item_code }}</q-td>
          <q-td key="item_name" :props="props"> {{ props.row.item_name }}</q-td>
          <q-td key="item_price" :props="props">
            {{ props.row.item_price }}</q-td
          >
          <q-td key="item_units" :props="props">
            {{ props.row.item_units }}</q-td
          >
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script>
import { ref } from "vue";
import { api } from "boot/axios"; //use this when you want api baseurl and axios is set in the boot

const loading = ref(true); //loading bar
// op_id
// item_code
// item_name
// item_price
// item_units
const columns = [
  {
    name: "op_id",
    required: true,
    align: "left",
    label: "Id",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "item_code",
    required: true,
    align: "left",
    label: "Item Code",
    field: "item_code",
    sortable: true,
  },
  {
    name: "item_name",
    required: true,
    align: "left",
    label: "Item Name",
    field: "item_name",
    sortable: true,
  },
  {
    name: "item_price",
    required: true,
    align: "left",
    label: "Item Price",
    field: "item_price",
    sortable: true,
  },
  {
    name: "item_units",
    required: true,
    align: "left",
    label: "Item Units",
    field: "item_units",
    sortable: true,
  },
];
const rows = ref([{}]); //container for table data

export default {
  name: "DispOpeningStock",

  data() {
    return {};
  },

  setup() {
    return {
      filter: ref(""),
      loading,
      columns,
      rows,

      dialog: ref(false),
      maximizedToggle: ref(false),
    };
  },

  components: {},

  methods: {
    getUserData() {
      //get all data from database
      api
        .get("disp_opening_stock.php")
        .then((response) => {
          rows.value = response.data.arraydata;
        })
        .finally(() => {
          loading.value = false;
        });
    },
  },

  beforeMount: function () {
    this.getUserData();
  },
};
</script>

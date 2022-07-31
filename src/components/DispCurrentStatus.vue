<template>
  <div class="q-pa-md">
    <!--
      totalOpeningStock
      totalPurchases
      totalSales
      totaClosingStock
      totalStockValue
     -->
    <div class="row flex-center q-pa-md q-gutter-md">
      <div class="col q-pa-sm text-center bg-blue-6 text-white">
        <!-- <q-icon name="groups" size="md" /> -->
        <span class="text-subtitle2"> Total Opening Stock </span>
        <br />
        <span class="text-h3">{{ totalOpeningStock }}</span>
      </div>
      <div class="col q-pa-sm text-center bg-blue-6 text-white">
        <!-- <q-icon name="groups" size="md" /> -->
        <span class="text-subtitle2"> Total Purchases </span>
        <br />
        <span class="text-h3">{{ totalPurchases }}</span>
      </div>
      <div class="col q-pa-sm text-center bg-blue-6 text-white">
        <!-- <q-icon name="groups" size="md" /> -->
        <span class="text-subtitle2"> Total Sales </span>
        <br />
        <span class="text-h3">{{ totalSales }}</span>
      </div>
      <div class="col q-pa-sm text-center bg-blue-6 text-white">
        <!-- <q-icon name="groups" size="md" /> -->
        <span class="text-subtitle2"> Total Closing Stock </span>
        <br />
        <span class="text-h3">{{ totaClosingStock }}</span>
      </div>
      <div class="col q-pa-sm text-center bg-blue-6 text-white">
        <!-- <q-icon name="groups" size="md" /> -->
        <span class="text-subtitle2"> Total Stock Value </span>
        <br />
        <span class="text-h3">₱ {{ totalStockValue }}</span>
      </div>
    </div>

    <q-table
      title="Current Status of Stock"
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
            ₱ {{ props.row.item_price }}</q-td
          >
          <q-td key="item_units" :props="props">
            {{ props.row.item_units }}</q-td
          >
          <q-td key="purchases" :props="props"> {{ props.row.purchases }}</q-td>
          <q-td key="sales" :props="props"> {{ props.row.sales }}</q-td>
          <q-td key="op_id" :props="props">
            {{ props.row.item_units + props.row.purchases - props.row.sales }}
          </q-td>
          <q-td key="op_id" :props="props">
            ₱
            {{
              (props.row.item_units + props.row.purchases - props.row.sales) *
              props.row.item_price
            }}
          </q-td>
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
    label: "Price / Unit",
    field: "item_price",
    sortable: true,
  },
  {
    name: "item_units",
    required: true,
    align: "left",
    label: "Opening Stocks",
    field: "item_units",
    sortable: true,
  },
  {
    name: "purchases",
    required: true,
    align: "left",
    label: "Purchases",
    field: "purchases",
    sortable: true,
  },
  {
    name: "sales",
    required: true,
    align: "left",
    label: "Sales",
    field: "sales",
    sortable: true,
  },
  {
    name: "op_id",
    required: true,
    align: "left",
    label: "Closing Stock",
    field: "op_id",
    sortable: true,
  },
  {
    name: "op_id",
    required: true,
    align: "left",
    label: "Total Stock Value",
    field: "op_id",
    sortable: true,
  },
];
const rows = ref([{}]); //container for table data

export default {
  name: "DispCurrentStatus",

  data() {
    return {
      totalOpeningStock: 0,
      totalPurchases: 0,
      totalSales: 0,
      totaClosingStock: 0,
      totalStockValue: 0,
    };
  },

  setup() {
    return {
      filter: ref(""),
      loading,
      columns,
      rows,

      dialog: ref(false),
      maximizedToggle: ref(false),

      alert: ref(false), //for delete
    };
  },

  components: {},

  methods: {
    getData() {
      //get all data from database
      api
        .get("disp_current_status.php")
        .then((response) => {
          rows.value = response.data.arraydata;
          this.totalOpeningStock = response.data.totalOpeningStock;
          this.totalPurchases = response.data.totalPurchases;
          this.totalSales = response.data.totalSales;
          this.totaClosingStock = response.data.totaClosingStock;
          this.totalStockValue = response.data.totalStockValue;
        })
        .finally(() => {
          loading.value = false;
        });
    },
  },

  beforeMount: function () {
    this.getData();
  },
};
</script>

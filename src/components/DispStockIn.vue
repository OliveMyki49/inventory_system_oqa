<template>
  <div class="q-pa-md">
    <q-table
      title="Stock In"
      :loading="loading"
      :rows="rows"
      :columns="columns"
      row-key="name"
      :filter="filter"
      binary-state-sort
    >
      <template v-slot:top-left>
        <span class="text-h6">Stock In</span>
        &nbsp;
        <span class="bg-blue-6 text-white q-pa-sm">
          Total Units: {{ totalUnits }}
        </span>
        &nbsp;
        <span class="bg-blue-6 text-white q-pa-sm">
          Total Stock Value: ₱ {{ totalStockValue }}
        </span>
      </template>

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
          <q-td key="si_id" :props="props"> {{ props.row.si_id }}</q-td>
          <q-td key="date" :props="props"> {{ props.row.date }}</q-td>
          <q-td key="item_code" :props="props"> {{ props.row.item_code }}</q-td>
          <q-td key="item_name" :props="props"> {{ props.row.item_name }}</q-td>
          <q-td key="item_price" :props="props">
            ₱ {{ props.row.item_price }}</q-td
          >
          <q-td key="units" :props="props"> {{ props.row.units }}</q-td>

          <q-td key="op_id" :props="props">
            ₱ {{ props.row.item_price * props.row.units }}
          </q-td>
          <q-td key="op_id" :props="props">
            <q-btn
              icon="edit"
              size="md"
              class="bg-secondary text-white"
              @click="
                selectItem(
                  props.row.si_id,
                  props.row.op_id,
                  props.row.item_code,
                  props.row.units
                );
                getDataOS();
              "
            >
              <q-tooltip> edit </q-tooltip>
            </q-btn>
          </q-td>
          <q-td key="op_id" :props="props">
            <q-btn
              icon="delete"
              size="md"
              class="bg-red text-white"
              @click="
                this.del_item_id = props.row.si_id;
                this.del_item_name = props.row.item_name;
                alert = true;
              "
            >
              <q-tooltip> delete </q-tooltip>
            </q-btn>
          </q-td>
        </q-tr>
      </template>
    </q-table>

    <!-- Confirm Delete -->
    <q-dialog v-model="alert">
      <q-card style="width: 300px">
        <q-card-section class="q-pt-md">
          <div class="text-h6 text-center">
            Delete Item:
            <b>{{ del_item_name }} </b>?
          </div>
        </q-card-section>

        <q-card-actions align="center">
          <q-btn flat label="CANCEL" color="primary" v-close-popup />
          <q-btn flat label="OK" color="red-6" @click="remove(del_item_id)" />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <!-- Update -->
    <q-dialog
      v-model="dialog"
      persistent
      :maximized="maximizedToggle"
      transition-show="slide-up"
      transition-hide="slide-down"
      full-width
    >
      <q-card class="bg-white q-card" style="width: 800px">
        <q-bar class="bg-primary text-white q-bar">
          <div class="text-h6 text-uppercase">Update Item Form</div>
          <q-space />
          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="uptItem" class="q-gutter-md">
            <div class="q-pa-lg row q-gutter-md">
              <div class="col-7">
                <q-table
                  title="Opening Stock"
                  :loading="loading"
                  :rows="rowsOS"
                  :columns="columnsOS"
                  row-key="name"
                  :filter="filterOS"
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
                      <q-td key="item_code" :props="props">
                        {{ props.row.item_code }}</q-td
                      >
                      <q-td key="item_name" :props="props">
                        {{ props.row.item_name }}</q-td
                      >
                      <q-td key="op_id" :props="props">
                        <q-btn
                          size="md"
                          color="blue-6"
                          icon="add"
                          @click="
                            inputData.op_id = props.row.op_id;
                            inputData.item_code = props.row.item_code;
                          "
                        />
                        <q-tooltip> Select Item </q-tooltip>
                      </q-td>
                    </q-tr>
                  </template>
                </q-table>
              </div>
              <div class="col-4 q-gutter-sm">
                <q-input
                  square
                  filled
                  clearable
                  v-model="inputData.item_code"
                  type="text"
                  min="0"
                  label="Item Code"
                  require
                  disable
                />

                <q-input
                  square
                  filled
                  clearable
                  v-model="inputData.units"
                  type="number"
                  min="0"
                  label="Item Units"
                  require
                />

                <div>
                  <div
                    v-if="inputData.item_code != '' && inputData.units != ''"
                  >
                    <q-btn
                      type="submit"
                      unelevated
                      color="blue-9"
                      size="lg"
                      class="full-width"
                      label="Update Item"
                    />
                  </div>
                  <div v-else>
                    <q-btn
                      unelevated
                      color="blue-9"
                      size="lg"
                      class="full-width"
                      label="Update Item"
                      disable
                    />
                  </div>
                </div>
              </div>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { ref } from "vue";
import { api } from "boot/axios"; //use this when you want api baseurl and axios is set in the boot

const loading = ref(true); //loading bar
// si_id
// op_id
// item_code
// item_name
// item_price
// units
const columns = [
  {
    name: "si_id",
    required: true,
    align: "left",
    label: "Id",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "date",
    required: true,
    align: "left",
    label: "Date",
    field: "date",
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
    name: "units",
    required: true,
    align: "left",
    label: "Units",
    field: "units",
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
  {
    name: "op_id",
    required: true,
    align: "left",
    label: "",
    field: "op_id",
    sortable: true,
  },
  {
    name: "op_id",
    required: true,
    align: "left",
    label: "",
    field: "op_id",
    sortable: true,
  },
];
const rows = ref([{}]); //container for table data

const columnsOS = [
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
    name: "op_id",
    required: true,
    align: "left",
    label: "",
    field: "op_id",
    sortable: true,
  },
];
const rowsOS = ref([{}]); //container for table data

export default {
  name: "DispStockIn",

  data() {
    return {
      inputData: {
        si_id: "",
        op_id: "",
        item_code: "",
        units: "",
      },

      del_item_id: "",
      del_item_name: "",

      totalUnits: "",
      totalStockValue: "",
    };
  },

  setup() {
    return {
      filter: ref(""),
      loading,
      columns,
      rows,

      filterOS: ref(""),
      columnsOS,
      rowsOS,

      dialog: ref(false),
      maximizedToggle: ref(false),

      alert: ref(false), //for delete
    };
  },

  methods: {
    async uptItem() {
      const response = await api.put(
        "update_stock_in.php?si_id=" + this.inputData.si_id,
        {
          d1: this.inputData.op_id,
          d2: this.inputData.units,
        }
      );

      //alert(response.data.msg);
      this.getData();

      this.inputData.op_id = "";
      this.inputData.units = "";

      this.dialog = false; //close dialog box
    },

    remove(si_id) {
      api.delete("delete_stock_in.php?si_id=" + si_id).then((response) => {
        //alert(response.data.msg);
        this.getData();

        this.alert = false; //close alert
      });
    },

    selectItem(si_id, op_id, item_code, units) {
      this.inputData.si_id = si_id;
      this.inputData.op_id = op_id;
      this.inputData.item_code = item_code;
      this.inputData.units = units;

      this.getDataOS();

      this.dialog = true;
    },

    getData() {
      //get all data from database
      api
        .get("disp_stock_in.php")
        .then((response) => {
          rows.value = response.data.arraydata;
          this.totalUnits = response.data.totalUnits;
          this.totalStockValue = response.data.totalStockValue;
        })
        .finally(() => {
          loading.value = false;
        });
    },

    getDataOS() {
      //get all data from database
      api
        .get("disp_opening_stock.php")
        .then((response) => {
          rowsOS.value = response.data.arraydata;
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

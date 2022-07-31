<template>
  <div class="q-pa-md q-gutter-sm">
    <q-btn
      class="fixed-bottom-right btn-add-user"
      color="primary"
      rounded
      @click="dialog = true"
    >
      <!-- <q-icon left size="2em" name="person_add_alt" /> -->
      <label>Add New Item</label>
    </q-btn>

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
          <div class="text-h6 text-uppercase">Add Item</div>
          <q-space />
          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="addItem" class="q-gutter-md">
            <div class="q-pa-lg row q-gutter-md">
              <div class="col-7">
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
                      label="Add Item"
                    />
                  </div>
                  <div v-else>
                    <q-btn
                      unelevated
                      color="blue-9"
                      size="lg"
                      class="full-width"
                      label="Add Item"
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
const columns = [
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
const rows = ref([{}]); //container for table data

export default {
  name: "AddStockOut",

  data() {
    return {
      inputData: {
        op_id: "",
        item_code: "",
        units: "",
      },
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
    };
  },

  methods: {
    currentDate() {
      let timestamp = Date.now();
      let d = new Date(timestamp);
      let current_date =
        d.getFullYear() +
        "-" +
        ("00" + (d.getMonth() + 1)).slice(-2) +
        "-" +
        ("00" + d.getDate()).slice(-2);

      return current_date;
    },

    getData() {
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

    async addItem() {
      const response = await api.post("add_stock_out.php", {
        d1: this.inputData.op_id,
        d2: this.inputData.units,
        d3: this.currentDate(),
      });

      //alert(response.data.msg);
      this.$emit("rerender-table");

      this.inputData.op_id = "";
      this.inputData.item_code = "";
      this.inputData.units = "";

      this.dialog = false; //close dialog box
    },
  },

  beforeMount: function () {
    this.getData();
  },
};
</script>

<style>
.btn-add-user {
  margin-right: 10px;
  margin-bottom: 10px;
}

.q-card {
  width: 100%;
}

.q-bar {
  height: 50px;
}
</style>

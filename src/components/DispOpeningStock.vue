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
          <q-td key="op_id" :props="props">
            {{ props.row.item_price * props.row.item_units }}
          </q-td>
          <q-td key="op_id" :props="props">
            <q-btn
              icon="edit"
              size="md"
              class="bg-secondary text-white"
              @click="
                selectItem(
                  props.row.op_id,
                  props.row.item_code,
                  props.row.item_name,
                  props.row.item_price,
                  props.row.item_units
                )
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
                this.del_item_id = props.row.op_id;
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
    >
      <q-card class="bg-white q-card" style="width: 400px">
        <q-bar class="bg-primary text-white q-bar">
          <div class="text-h6 text-uppercase">Update Item Form</div>
          <q-space />
          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="uptItem" class="q-gutter-md">
            <div class="q-pa-lg q-gutter-md">
              <q-input
                square
                filled
                clearable
                v-model="inputData.item_code"
                type="text"
                min="0"
                label="Item Code"
                require
              />

              <q-input
                square
                filled
                clearable
                v-model="inputData.item_name"
                type="text"
                min="0"
                label="Item Name"
                require
              />

              <q-input
                filled
                v-model="inputData.item_price"
                label="Item Price"
                mask="#.##"
                fill-mask="0"
                reverse-fill-mask
                input-class="text-right"
                require
              />

              <q-input
                square
                filled
                clearable
                v-model="inputData.item_units"
                type="number"
                min="0"
                label="Item Units"
                require
              />

              <div class="col-12">
                <div
                  v-if="
                    inputData.item_code != '' &&
                    inputData.item_name != '' &&
                    inputData.item_price != '' &&
                    inputData.item_units != ''
                  "
                >
                  <div v-if="inputData.item_price != '0.00'">
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

export default {
  name: "DispOpeningStock",

  data() {
    return {
      inputData: {
        op_id: "",
        item_code: "",
        item_name: "",
        item_price: "",
        item_units: "",
      },

      del_item_id: "",
      del_item_name: "",
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
    async uptItem() {
      const response = await api.put(
        "update_opening_stock.php?op_id=" + this.inputData.op_id,
        {
          d1: this.inputData.item_code,
          d2: this.inputData.item_name,
          d3: this.inputData.item_price,
          d4: this.inputData.item_units,
        }
      );

      //alert(response.data.msg);
      this.getData();

      this.inputData.item_code = "";
      this.inputData.item_name = "";
      this.inputData.item_price = "";
      this.inputData.item_units = "";

      this.dialog = false; //close dialog box
    },

    remove(op_id) {
      api.delete("delete_opening_stock.php?op_id=" + op_id).then((response) => {
        //alert(response.data.msg);
        this.getData();

        this.alert = false; //close alert
      });
    },

    selectItem(op_id, item_code, item_name, item_price, item_units) {
      this.inputData.op_id = op_id;
      this.inputData.item_code = item_code;
      this.inputData.item_name = item_name;
      this.inputData.item_price = item_price;
      this.inputData.item_units = item_units;

      this.dialog = true;
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
  },

  beforeMount: function () {
    this.getData();
  },
};
</script>

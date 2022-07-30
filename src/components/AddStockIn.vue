<template>
  <div class="q-pa-md q-gutter-sm">
    <q-btn
      class="fixed-bottom-right btn-add-user"
      color="primary"
      rounded
      @click="dialog = true"
      ><q-icon left size="2em" name="person_add_alt" />
      <label>Add New Item</label>
    </q-btn>

    <q-dialog
      v-model="dialog"
      persistent
      :maximized="maximizedToggle"
      transition-show="slide-up"
      transition-hide="slide-down"
    >
      <q-card class="bg-white q-card" style="width: 400px">
        <q-bar class="bg-primary text-white q-bar">
          <div class="text-h6 text-uppercase">Add Item</div>
          <q-space />
          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="addItem" class="q-gutter-md">
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
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { ref } from "vue";
import { api } from "boot/axios"; //use this when you want api baseurl and axios is set in the boot

export default {
  name: "AddStockIn",

  data() {
    return {
      inputData: {
        item_code: "",
        item_name: "",
        item_price: "",
        item_units: "",
      },
    };
  },

  setup() {
    return {
      dialog: ref(false),
      maximizedToggle: ref(false),
    };
  },

  methods: {
    async addItem() {
      const response = await api.post("add_opening_stock.php", {
        d1: this.inputData.item_code,
        d2: this.inputData.item_name,
        d3: this.inputData.item_price,
        d4: this.inputData.item_units,
      });

      alert(response.data.msg);
      this.$emit("rerender-table");

      this.inputData.item_code = "";
      this.inputData.item_name = "";
      this.inputData.item_price = "";
      this.inputData.item_units = "";

      this.dialog = false; //close dialog box
    },
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

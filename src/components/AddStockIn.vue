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
      <q-card class="bg-white q-card">
        <q-bar class="bg-primary text-white q-bar">
          <div class="text-h6 text-uppercase">Add User</div>
          <q-space />
          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section class="q-pt-none">
          <br />
          <!-- <q-form @submit.prevent="addUserAcc" class="q-gutter-md"> -->
          <q-form class="q-gutter-md">
            <div class="q-pa-lg q-gutter-md">
              <q-input
                square
                filled
                clearable
                v-model="inputData.official_id"
                type="number"
                min="0"
                label="Barangay Official ID"
                require
                disable
              />
              <div>
                <q-input
                  square
                  filled
                  clearable
                  v-model="inputData.fullname"
                  type="text"
                  label="Full Name"
                  require
                />
                <q-tooltip> Search Barangay Official </q-tooltip>
              </div>

              <div>
                <q-btn
                  type="submit"
                  unelevated
                  color="blue-9"
                  size="lg"
                  class="full-width"
                  label="Add User"
                />
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
        official_id: "",
        fullname: "",
      },
    };
  },

  setup() {
    return {
      dialog: ref(false),
      maximizedToggle: ref(false),
    };
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

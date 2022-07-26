<template>
  <q-page class="bg-light-blue row justify-center items-center">
    <div class="column">
      <form @submit.prevent="actLogin">
        <div class="row">
          <h3 class="text-h3 text-white q-my-lg">Sign-in</h3>
        </div>
        <div class="row">
          <q-card square bordered class="q-pa-lg shadow-1">
            <q-card-section>
              <q-form class="q-gutter-md">
                <q-input
                  square
                  filled
                  clearable
                  v-model="loginFormData.username"
                  type="text"
                  label="username"
                  require
                />
                <q-input
                  square
                  filled
                  clearable
                  v-model="loginFormData.password"
                  type="password"
                  label="password"
                  require
                />
                <div class="q-my-none text-right">
                  <span class="text-blue-6 cursor-pointer">
                    forgot password

                    <q-popup-edit
                      title=""
                      style="width: 400px"
                      v-model="loginFormData.username"
                    >
                      <div class="subtitle1 text-center text-grey-7">
                        Lost your password? Please enter your username. You'll
                        receive SMS on your registered resident contact number
                        for your new password.
                      </div>
                      <q-input
                        square
                        filled
                        clearable
                        v-model="loginFormData.username"
                        type="text"
                        label="username"
                        require
                      />

                      <div class="q-pa-sm">
                        <q-btn
                          class="full-width"
                          color="blue"
                          @click="resetPass()"
                        >
                          reset my password
                        </q-btn>
                      </div>
                    </q-popup-edit>
                  </span>
                </div>
              </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md">
              <q-btn
                type="submit"
                unelevated
                color="light-green-7"
                size="lg"
                class="full-width"
                label="Login"
              />
            </q-card-actions>
          </q-card>
        </div>
      </form>
      <p class="text-weight-medium text-white">
        Note: Login is only exclusive to barangay officials
      </p>
    </div>
  </q-page>
</template>

<script>
export default {
  name: "LoginPage",

  data() {
    return {
      loginFormData: {
        username: "",
        password: "",
      },
      verificationStatusStored: "",
    };
  },
};
</script>

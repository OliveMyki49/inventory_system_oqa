<template>
  <q-page class="bg-light-blue row justify-center items-center">
    <div class="col-4">
      <form @submit.prevent="actLogin">
        <div class="col">
          <h3 class="text-h3 text-white q-my-lg">Sign-in</h3>
        </div>
        <div class="col">
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
                <!-- <div class="q-my-none text-right">
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
                </div> -->
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
      <!-- <p class="text-weight-medium text-white">Note: Sample Here</p> -->
    </div>
  </q-page>
</template>

<script>
import { api } from "boot/axios"; //use this when you want api baseurl and axios is set in the boot

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

  methods: {
    async actLogin() {
      if (
        this.loginFormData.username != "" &&
        this.loginFormData.password != ""
      ) {
        const response = await api.post("login.php", {
          d1: this.loginFormData.username,
          d2: this.loginFormData.password,
        });

        if (response.data.login == true) {
          setSession(response.data, this.loginFormData.username);
          this.$router.push("/dashboard"); //redirect to user dashboard
        } else {
          alert(response.data.msg); //display alert message

          this.loginFormData.username = ""; //clear inputs in login form
          this.loginFormData.password = "";
        }
      } else {
        alert("Fill up all inputs first");
      }
    },
  },
};

function setSession(res, uname) {
  //save user account info in session
  //res means response data
  sessionStorage.setItem("user_id", res.user_id);
  sessionStorage.setItem("uname", uname);
  sessionStorage.setItem("token", res.token);
  sessionStorage.setItem("user_auth_id", res.user_auth_id);
}
</script>

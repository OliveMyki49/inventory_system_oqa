<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title> Inventory System </q-toolbar-title>

        <div>
          <q-btn
            color="blue"
            target="_self"
            href="/#/"
            icon="perm_identity"
            label="Logout"
            size="14px"
          />
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header> Essential Links </q-item-label>

        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from "vue";
import EssentialLink from "components/EssentialLink.vue";
import { api } from "boot/axios"; //use this when you want api baseurl and axios is set in the boot

const linksList = [
  {
    title: "Docs",
    caption: "quasar.dev",
    icon: "school",
    link: "https://quasar.dev",
  },
  {
    title: "Github",
    caption: "github.com/quasarframework",
    icon: "code",
    link: "https://github.com/quasarframework",
  },
  {
    title: "Discord Chat Channel",
    caption: "chat.quasar.dev",
    icon: "chat",
    link: "https://chat.quasar.dev",
  },
  {
    title: "Forum",
    caption: "forum.quasar.dev",
    icon: "record_voice_over",
    link: "https://forum.quasar.dev",
  },
  {
    title: "Twitter",
    caption: "@quasarframework",
    icon: "rss_feed",
    link: "https://twitter.quasar.dev",
  },
  {
    title: "Facebook",
    caption: "@QuasarFramework",
    icon: "public",
    link: "https://facebook.quasar.dev",
  },
  {
    title: "Quasar Awesome",
    caption: "Community Quasar projects",
    icon: "favorite",
    link: "https://awesome.quasar.dev",
  },
];

export default defineComponent({
  name: "MainLayout",

  components: {
    EssentialLink,
  },

  setup() {
    const leftDrawerOpen = ref(false);

    return {
      essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
    };
  },

  beforeMount: function () {
    /*Get Current Date*/
    let timestamp = Date.now();
    let d = new Date(timestamp);
    let current_date =
      d.getFullYear() +
      "-" +
      ("00" + (d.getMonth() + 1)).slice(-2) +
      "-" +
      ("00" + d.getDate()).slice(-2) +
      " " +
      ("00" + d.getHours()).slice(-2) +
      ":" +
      ("00" + d.getMinutes()).slice(-2) +
      ":" +
      ("00" + d.getSeconds()).slice(-2);

    //verify authentication if it exist
    api
      .get("user_auth.php?d1=" + sessionStorage.getItem("user_auth_id"))
      .then((response) => {
        let res = response.data; //shorten response data call

        let user_id = sessionStorage.getItem("user_id");
        let token = sessionStorage.getItem("token");

        if (res.auth == true) {
          //validate if account is still avalable
          if (res.user_id == user_id) {
            //check if user id match the authentication
            if (res.token == token) {
              //check token if matched
              if (new Date(res.expiration) > new Date(current_date)) {
                //check if token is not yet expired
                console.log("token credible");
              } else {
                alert("token expired");
              }
            } else {
              alert("JWT token does not match!!!");
              window.location.replace("/#/");
            }
          } else {
            alert("user id for authentication does not match");
            window.location.replace("/#/");
          }
        } else {
          alert("authentication session not found \nPlease Login again");
          window.location.replace("/#/");
        }
      })
      .catch(function (error) {
        if (error.response) {
          console.log(error.response.data);
          window.location.replace("/#/");
        }
      });
  },
});
</script>

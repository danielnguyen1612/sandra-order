<template>
  <v-app>
    <v-card flat>
      <v-toolbar
        color="primary"
        dark
        extended
        flat
      >
      </v-toolbar>

      <v-card
        class="mx-auto"
        max-width="80%"
        style="margin-top: -64px;"
      >
        <v-toolbar flat>
          <v-toolbar-title>
            Ms. Jackelien - From Sandra with love ❤️
          </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-scale-transition>
            <AddItemComponent v-if="!loading"/>
          </v-scale-transition>

          <v-scale-transition>
            <v-btn
              color="primary"
              @click="generatePDF"
              :loading="loading"
              :disabled="loading"
            >
              <v-icon class="mr-2">mdi-cloud-download</v-icon>
              Generate PDF
            </v-btn>
          </v-scale-transition>
        </v-toolbar>
        <v-divider></v-divider>
        <v-card-text>
          <h3>List of groups</h3>
          <v-simple-table>
            <template v-slot:default>
              <thead>
              <tr>
                <th class="text-left">
                  No
                </th>
                <th class="text-left">
                  Items
                </th>
                <th class="text-left">Actions</th>
              </tr>
              </thead>
              <tbody>
              <tr
                v-for="(item, idx) in items"
                :key="item.key"
              >
                <td>{{ idx + 1 }}</td>
                <td>
                  <ul>
                    <li v-for="text in item.textItems" :key="text">{{ text }}</li>
                  </ul>
                </td>
                <td>
                  <v-btn
                    icon
                    color="red darken-4"
                    @click="removeItem(idx)"
                    v-if="!loading"
                  >
                    <v-icon>mdi-trash-can</v-icon>
                  </v-btn>
                </td>
              </tr>
              <tr v-if="!items.length">
                <td colspan="5" class="text-center blue-grey--text lighten-2">No group</td>
              </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-card>
  </v-app>
</template>

<script>
import AddItemComponent from './dialogs/AddItemComponent'
import { mapGetters } from 'vuex';
import moment from 'moment';

export default {
  components: {
    AddItemComponent,
  },

  computed: {
    ...mapGetters({
      items: 'getItems'
    })
  },

  data() {
    return {
      loading: false,
    }
  },

  methods: {
    async removeItem(index) {
      const res = await this.$confirm("Do you really want to remove this item ?", {
        color: "primary",
      });
      if (!res) return;

      this.$store.commit('REMOVE_ITEM', index);
    },

    async generatePDF() {
      if (!this.items.length) {
        this.$toast.error('You should add group at first!');
        return false;
      }

      this.loading = true;
      try {
        const response = await axios.post('/export', {
          items: this.items,
          responseType: 'blob', // important
        });

        const timestamp = moment().format('YYYYMMDD');
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `order_${timestamp}.pdf`); //or any other extension
        document.body.appendChild(link);
        link.click();
        this.$toast.success('The PDF file has been generated and downloaded!');
        this.$store.commit('RESET_ITEMS');
      } catch(e) {
        this.$toast.error('An error occurred, please try again!');
      }
      this.loading = false;
    }
  }
}
</script>

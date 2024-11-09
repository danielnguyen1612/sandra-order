<template>
  <div class="text-center">
    <v-dialog
      eager
      v-model="dialog"
      persistent
      max-width="800"
      hide-overlay
      transition="dialog-bottom-transition"
      overlay-color="indigo"
      :overlay-opacity="0.8"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="mr-3"
          color="primary"
          v-bind="attrs"
          v-on="on"
        >
          <v-icon>mdi-plus</v-icon>
          Add group
        </v-btn>
      </template>

      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-btn
            icon
            dark
            @click="dialogClose"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>{{ edit === null ? 'Add new' : 'Edit' }} group of items</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="addItem"
            >
              Save
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container class="mt-5">
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-combobox
                  v-model="form.type"
                  :items="types"
                  :rules="rules.type"
                  label="Type"
                ></v-combobox>
              </v-row>
              <v-row>
                <v-combobox
                  v-model="form.type2"
                  :items="types2"
                  :rules="rules.type2"
                  label="Type 2"
                ></v-combobox>
              </v-row>
              <v-row>
                <v-combobox
                  v-model="form.size"
                  :items="sizes"
                  :rules="rules.size"
                  label="Size"
                ></v-combobox>
              </v-row>
              <v-row>
                <v-combobox
                  v-model="form.quantity"
                  :items="quantity"
                  :rules="rules.quantity"
                  label="Quantity"
                ></v-combobox>
              </v-row>
              <v-row>
                <v-combobox
                  multiple
                  chips
                  validate-on-blur
                  v-model="form.colors"
                  :rules="rules.colors"
                  :deletable-chips="true"
                  :clearable="true"
                  :items="colors"
                  label="Colors"
                ></v-combobox>
              </v-row>
              <v-row>
                <v-btn
                  :disabled="!valid"
                  class="float-right"
                  outlined
                  small
                  block
                  color="indigo"
                  @click="confirm">
                  <v-icon>
                    mdi-plus
                  </v-icon>
                  Add item
                </v-btn>
              </v-row>
            </v-form>
          </v-container>

          <v-container class="mt-2">
            <v-simple-table>
              <template v-slot:default>
                <thead>
                <tr>
                  <th class="text-left">
                    Type
                  </th>
                  <th class="text-left">
                    Size
                  </th>
                  <th class="text-left">
                    Quantity
                  </th>
                  <th class="text-left">
                    Colors
                  </th>
                  <th class="text-left">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr
                  v-for="(item, idx) in items"
                  :key="item.key"
                >
                  <td>{{ item.type }}</td>
                  <td>{{ item.size }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ item.colors.join(',') }}</td>
                  <td>
                    <v-btn
                      icon
                      color="red darken-4"
                      @click="removeItem(idx)"
                    >
                      <v-icon>mdi-trash-can</v-icon>
                    </v-btn>
                  </td>
                </tr>
                <tr v-if="!items.length">
                  <td colspan="5" class="text-center blue-grey--text lighten-2">No item</td>
                </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { v4 as uuid } from 'uuid'
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      edit: 'itemEdit',
      storeItems: 'getItems',
    })
  },

  data() {
    return {
      valid: true,
      dialog: false,
      form: {
        type: '',
        type2: '',
        size: '',
        quantity: '',
        colors: [],
      },
      rules: {
        type: [
          v => !!v || 'Type is required',
          v => this.types.includes(v) || 'Type is not valid'
        ],
        type2: [
          v => !!v || 'Type 2 is required',
          v => this.types2.includes(v) || 'Type2 is not valid'
        ],
        size: [
          v => !!v || 'Size is required',
          v => this.sizes.includes(v) || 'Type is not valid'
        ],
        quantity: [
          v => !!v || 'Quantity is required'
        ],
        colors: [
          v => !!v.length || 'You should choose at least one color',
          v => v.every(item => this.colors.includes(item)) || 'Some of selected colors are not valid'
        ]
      },
      types: [
        'SD',
        'DD',
        'Frontal',
        'Clip In',
        'Ponytail',
        'Halo',
        'Genius Weft',
        'Seamless Clip In',
        'Long Tape',
        'Invisible Tape',
        'Full Lace Wigs',
        'Mono Topper 3x5',
        'Mono Topper 5x6',
        'Silk Base 4x4',
        'Silk Base 5x5',
        'Seamless Clip In',
        'Full End Wigs',
        'Wig Cap Size',
      ],
      types2: [
        'Normal',
        'Ombre',
        'Piano',
        'Ombre/ Piano'
      ],
      sizes: [
        "6\" (15cm)",
        "8\" (20cm)",
        "10\" (25cm)",
        "12\" (30cm)",
        "14\" (35cm)",
        "16\" (40cm)",
        "18\" (45cm)",
        "20\" (50cm)",
        "22\" (55cm)",
        "24\" (60cm)",
        "26\" (65cm)",
        "28\" (70cm)",
        "30\" (75cm)",
        "32\" (80cm)",
        "34\" (85cm)",
        "36\" (90cm)",
        "38\" (95cm)",
        "40\" (100cm)",
        "12",
        "Size S",
        "Size XS",
        "Size M",
        "Size L",
      ],
      quantity: Array.from(Array(20).keys()).map(v => v + 1).concat(...['200 gram', '250 gram', '350 gram', '450gram']),
      colors: [
        "#1", "#1A", "#1B", "Grey", "#2", "#3", "#4", "#6", "#8", "#5Q", "#6C", "#9C", "#12C", "#18C", "#8H", "#32H", "#33H", "#18", "#22", "#14", "#16", "#24",
        "#613", "#613Q", "#60", "#60C", "#2H", "#2Q", "#3Q", "#4Q", "#12", "#27", "Red", ".", "#1H", "1b", "613 ASH", "60 ASH", '1C', '3C', '4C', '5C', '6Q', '7Q',
        '6.1', '6.2', '34',
      ],
      items: [],
    }
  },

  watch: {
    edit: function(newVal, oldVal) {
      if (newVal !== null) {
        this.items = [...JSON.parse(JSON.stringify(this.storeItems[newVal].items))];
        this.dialog = true;
      }
    }
  },

  methods: {
    confirm() {
      if (!this.$refs.form.validate()) {
        return false;
      }

      this.items.splice(0, 0, {
        key: uuid(),
        type: this.form.type,
        type2: this.form.type2,
        size: this.form.size,
        quantity: this.form.quantity,
        colors: this.form.colors,
      })

      this.$refs.form.reset();
    },

    removeItem: async function(idx) {
      const res = await this.$confirm("Do you really want to remove this item ?", {
        color: "primary",
      });
      if (!res) return;

      this.items.splice(idx, 1);
    },

    async dialogClose() {
      this.items = [];
      this.$refs.form.reset();
      this.dialog = false;
      await this.$store.commit('CANCEL_EDIT');
    },

    async addItem() {
      if (!this.items.length) {
        this.$toast.error('You should add items at first!');
        return;
      }

      if (this.edit === null) {
        // Create
        await this.$store.commit('ADD_ITEM', {
          key: uuid(),
          items: [...this.items],
        });
      } else {
        await this.$store.commit('UPDATE_ITEM', {
          idx: this.edit,
          data: {
            key: uuid(),
            items: [...this.items],
          }
        });
      }

      this.dialogClose();
    }
  }
}
</script>

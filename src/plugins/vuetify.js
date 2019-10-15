import Vue from 'vue'
import Vuetify, {
    VApp,
    VRow,
    VCol,
    VSheet,
    VCalendar,
    VToolbar,
    VList,
    VListItem,
    VBtn,
    VIcon,
    VMenu,
    VCard,
    VCardText,
    VCardActions,
    VToolbarTitle,
    VListItemTitle
} from 'vuetify/lib'

Vue.use(Vuetify, {
    components: {
        VApp,
        VRow,
        VCol,
        VSheet,
        VCalendar,
        VToolbar,
        VList,
        VListItem,
        VBtn,
        VIcon,
        VMenu,
        VCard,
        VCardText,
        VCardActions,
        VToolbarTitle,
        VListItemTitle
    }
});

import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);

const opts = {};

export default new Vuetify(opts)

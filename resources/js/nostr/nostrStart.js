import {ndkInstance} from "./ndk/instance.js";

export default (livewireComponent) => ({



    async init() {

        await ndkInstance(this).init();

        console.log(this.$store.ndk.user);

        if (this.$store.ndk.user) {
            this.$wire.setUser(this.$store.ndk.user);
        }

    },

});

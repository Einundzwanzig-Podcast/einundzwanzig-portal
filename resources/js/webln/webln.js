import {requestProvider} from "webln";

export default (livewireComponent) => ({

    async init() {
        console.log('WeBLN initialized');

        let webln;
        try {
            webln = await requestProvider();
            console.log('WeBLN provider acquired');
            this.$wire.call('logThis', 'WeBLN provider acquired');
        } catch (err) {
            // Handle users without WebLN
            console.error('WeBLN provider request failed:', err);
            this.$wire.call('logThis', 'WeBLN provider request failed: ' + err);
        }
    },

});

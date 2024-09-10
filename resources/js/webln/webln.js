import {requestProvider} from "webln";

export default (livewireComponent) => ({

    async init() {
        console.log('WebLN initialized');

        let webln;
        try {
            webln = await requestProvider();
            console.log('WebLN provider acquired');
            this.$wire.call('logThis', 'WebLN provider acquired');

            // getInfo
            const info = await webln.getInfo();
            console.log('WebLN getInfo:', info);
            this.$wire.call('logThis', 'WebLN getInfo: ' + JSON.stringify(info));

        } catch (err) {
            // Handle users without WebLN
            console.error('WebLN provider request failed:', err);
            this.$wire.call('logThis', 'WebLN provider request failed: ' + err);
        }
    },

});

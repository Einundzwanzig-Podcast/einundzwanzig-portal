import {requestProvider} from "webln";

export default (livewireComponent) => ({

    invoice: livewireComponent.entangle('invoice'),

    async pay() {
        console.log('payment_request: ' + this.invoice.payment_request);
        await webln.sendPayment(this.invoice.payment_request)
            .then(response => {
                console.log('Payment response:', response);
                this.$wire.call('logThis', 'Payment response: ' + JSON.stringify(response));
                this.$wire.call('success');
            })
            .catch(error => {
                console.error('Payment failed:', error);
                this.$wire.call('logThis', 'Payment failed: ' + error);
                this.$wire.call('reloadMe');
            });
    },

    async keySendMethod() {
        // keysend(args: KeysendArgs): Promise<SendPaymentResponse>;
        // Send a keysend payment to the specified node.
        await webln.keysend({
            destination: '0363662a4ae8b8b7a73d9f4e459a9b25d4786f4ecc7315b5401934f3a2ef609750', amount: 1,
        })
            .then(response => {
                console.log('Payment response:', response);
                this.$wire.call('logThis', 'Payment response: ' + JSON.stringify(response));
                this.$wire.call('reloadMe');
            })
            .catch(error => {
                console.error('Payment failed:', error);
                this.$wire.call('logThis', 'Payment failed: ' + error);
                this.$wire.call('reloadMe');
            });
    },

    async init() {
        console.log('WebLN initialized');

        let webln;
        try {
            console.log(this.invoice);

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

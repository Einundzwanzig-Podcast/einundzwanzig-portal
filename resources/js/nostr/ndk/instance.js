import excplicitRelays from "./excplicitRelays.js";
import NDK from "@nostr-dev-kit/ndk";

export const ndkInstance = (Alpine) => ({
    async init() {
        try {
            const urls = excplicitRelays.map((relay) => {
                if (relay.startsWith('ws')) {
                    return relay.replace('ws', 'http');
                }
                if (relay.startsWith('wss')) {
                    return relay.replace('wss', 'https');
                }
            });

            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort('timeout'), 5000);

            const requests = urls.map((url) =>
                fetch(url, {
                    headers: {Accept: 'application/nostr+json'},
                    signal: controller.signal,
                })
            );
            const responses = await Promise.all(requests);
            const errors = responses.filter((response) => !response.ok);

            if (errors.length > 0) {
                throw errors.map((response) => Error(response.statusText));
            }

            let verifiedRelays = responses.map((res) => {
                if (res.url.startsWith('http')) {
                    return res.url.replace('http', 'ws');
                }
                if (res.url.startsWith('https')) {
                    return res.url.replace('https', 'wss');
                }
            });

            // clear timeout
            clearTimeout(timeoutId);

            console.log('##### verifiedRelays #####', verifiedRelays);
            Alpine.$store.ndk.explicitRelayUrls = verifiedRelays;

            const instance = new NDK({
                explicitRelayUrls: Alpine.$store.ndk.explicitRelayUrls,
                signer: Alpine.$store.ndk.nip07signer,
                cacheAdapter: Alpine.$store.ndk.dexieAdapter,
                outboxRelayUrls: ["wss://nostr.einundzwanzig.space",],
                enableOutboxModel: true,
            });

            try {
                await instance.connect(10000);
            } catch (error) {
                throw new Error('NDK instance init failed: ', error);
            }

            // store NDK instance in store
            Alpine.$store.ndk.ndk = instance;

            // init nip07 signer and fetch profile
            await Alpine.$store.ndk.nip07signer.user().then(async (user) => {
                if (!!user.npub) {
                    Alpine.$store.ndk.user = Alpine.$store.ndk.ndk.getUser({
                        npub: user.npub,
                    });
                    await Alpine.$store.ndk.user.fetchProfile();
                }
            }).catch((error) => {
                console.log('##### nip07 signer error #####', error);
            });
        } catch (e) {
            console.log(e);
        }
    }
});

import "./components"
import {Alpine, Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import {NDKNip07Signer} from "@nostr-dev-kit/ndk";
import NDKCacheAdapterDexie from "@nostr-dev-kit/ndk-cache-dexie";
import nostrStart from "./nostr/nostrStart";

Alpine.store('ndk', {
    // nostr ndk
    ndk: null,
    // signer
    nip07signer: new NDKNip07Signer(),
    // dexie cache adapter
    dexieAdapter: new NDKCacheAdapterDexie({dbName: 'einundzwanzigNostrDB', expirationTime: 60 * 60 * 24 * 7}),
    // current nostr user
    user: null,
    // hours ago
    explicitRelayUrls: [],
});
Alpine.data('nostrStart', nostrStart);

Livewire.start();

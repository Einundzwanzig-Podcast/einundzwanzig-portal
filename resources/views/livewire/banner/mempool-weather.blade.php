<div
    class="relative isolate flex items-center justify-center gap-x-6 overflow-hidden bg-gray-50 px-6 py-2.5 sm:px-3.5 sm:before:flex-1">
    <div class="absolute left-[max(-7rem,calc(50%-52rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl"
         aria-hidden="true">
        <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#FABE75] to-[#F7931A] opacity-30"
             style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
    </div>
    <div class="absolute left-[max(45rem,calc(50%+8rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl"
         aria-hidden="true">
        <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#FABE75] to-[#F7931A] opacity-30"
             style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
    </div>
    <div class="w-full flex flex-col sm:flex-row sm:space-x-4 justify-center">
        <div class="text-md leading-6 text-gray-900 text-center max-w-screen-2xl">
            {{ $weather }} (um {{ \App\Support\Carbon::parse($changed)->asTime() }} Uhr aktualisiert - stündlich)
        </div>
        <div>
            <div
                _ngcontent-serverapp-c131=""
                class="flex flex-col justify-around p-5 leading-6 text-center text-white break-words"
                style="min-height: 1px; list-style: outside;"
            >
                <app-fees-box
                    _ngcontent-serverapp-c131=""
                    class="block text-center break-words"
                    _nghost-serverapp-c126=""
                    style="list-style: outside;"
                >
                    <div
                        _ngcontent-serverapp-c126=""
                        class="text-white"
                        style="list-style: outside;"
                    >
                        <div
                            _ngcontent-serverapp-c126=""
                            class="flex break-words"
                            style="list-style: outside;"
                        >
                            <div
                                _ngcontent-serverapp-c126=""
                                class="flex flex-row mb-3 w-1/4 h-5 bg-lime-700"
                                style="background: rgb(93, 125, 1); --darkreader-inline-bgcolor: #4a6401; --darkreader-inline-bgimage: none; transition: background-color 1s ease 0s; list-style: outside;"
                                data-darkreader-inline-bgcolor=""
                                data-darkreader-inline-bgimage=""
                            >
                              <span
                                  _ngcontent-serverapp-c126=""
                                  ngbtooltip="Either 2x the minimum, or the Low Priority rate (whichever is lower)"
                                  placement="top"
                                  class="px-1 pt-px w-full text-xs leading-4 truncate"
                                  style="list-style: outside;"
                              >No Priority</span>
                            </div>
                            <div
                                _ngcontent-serverapp-c126=""
                                class="h-5 bg-white bg-opacity-[0]"
                                style="width: 4%; background-image: repeating-linear-gradient(90deg, rgb(36, 41, 58), rgb(36, 41, 58) 2px, rgb(23, 25, 39) 2px, rgb(23, 25, 39) 4px); list-style: outside;"
                            ></div>
                            <div
                                _ngcontent-serverapp-c126=""
                                class="flex flex-row mb-3 w-3/4 h-5"
                                style="background: linear-gradient(to right, rgb(93, 125, 1), rgb(166, 125, 14)); --darkreader-inline-bgcolor: rgba(0, 0, 0, 0); --darkreader-inline-bgimage: linear-gradient(to right, #4a6401, #85640b); transition: background-color 1s ease 0s; border-radius: 0px 10px 10px 0px; list-style: outside;"
                                data-darkreader-inline-bgcolor=""
                                data-darkreader-inline-bgimage=""
                            >
                          <span
                              _ngcontent-serverapp-c126=""
                              ngbtooltip="Usually places your transaction in between the second and third mempool blocks"
                              placement="top"
                              class="px-1 pt-px w-1/3 text-xs leading-4 truncate"
                              style="list-style: outside;"
                          >Hour</span><span
                                    _ngcontent-serverapp-c126=""
                                    ngbtooltip="Usually places your transaction in between the first and second mempool blocks"
                                    placement="top"
                                    class="px-1 pt-px w-1/3 text-xs leading-4 truncate"
                                    style="list-style: outside;"
                                >Half Hour</span
                                ><span
                                    _ngcontent-serverapp-c126=""
                                    ngbtooltip="Places your transaction in the first mempool block"
                                    placement="top"
                                    class="px-1 pt-px w-1/3 text-xs leading-4 truncate"
                                    style="list-style: outside;"
                                >Fastest</span
                                >
                            </div>
                        </div>
                        <div
                            _ngcontent-serverapp-c126=""
                            class="flex flex-row justify-between break-words"
                            style="list-style: outside;"
                        >
                            <div
                                _ngcontent-serverapp-c126=""
                                class="my-0 mx-auto w-24"
                                style="list-style: outside;"
                            >
                                <div
                                    _ngcontent-serverapp-c126=""
                                    class="mb-0 text-xl leading-8"
                                    style="list-style: outside;"
                                >
                                    <div
                                        _ngcontent-serverapp-c126=""
                                        class="m-auto leading-7 border-b border-gray-200 border-solid text-gray-900"
                                        style="list-style: outside;"
                                    >
                                        {{ $minimumFee }}
                                        <span
                                            _ngcontent-serverapp-c126=""
                                            class="inline-flex relative top-0 text-xs leading-4 text-gray-900"
                                            style="list-style: outside;"
                                        >sat/vB</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div
                                _ngcontent-serverapp-c126=""
                                class=""
                                style="width: 4%; list-style: outside;"
                            ></div>
                            <div
                                _ngcontent-serverapp-c126=""
                                class="my-0 mx-auto w-24"
                                style="list-style: outside;"
                            >
                                <div
                                    _ngcontent-serverapp-c126=""
                                    class="mb-0 text-xl leading-8"
                                    style="list-style: outside;"
                                >
                                    <div
                                        _ngcontent-serverapp-c126=""
                                        class="m-auto leading-7 border-b border-gray-200 border-solid text-gray-900"
                                        style="list-style: outside;"
                                    >
                                        {{ $hourFee }}
                                        <span
                                            _ngcontent-serverapp-c126=""
                                            class="inline-flex relative top-0 text-xs leading-4 text-gray-900"
                                            style="list-style: outside;"
                                        >sat/vB</span>
                                    </div>
                                    <span
                                        _ngcontent-serverapp-c126=""
                                        class="block relative top-0 text-xs leading-5 text-gray-900"
                                        style="list-style: outside;"
                                    ></span>
                                </div>
                            </div>
                            <div
                                _ngcontent-serverapp-c126=""
                                class="my-0 mx-auto w-24"
                                style="list-style: outside;"
                            >
                                <div
                                    _ngcontent-serverapp-c126=""
                                    class="mb-0 text-xl leading-8"
                                    style="list-style: outside;"
                                >
                                    <div
                                        _ngcontent-serverapp-c126=""
                                        class="m-auto leading-7 border-b border-gray-200 border-solid text-gray-900"
                                        style="list-style: outside;"
                                    >
                                        {{ $halfHourFee }}
                                        <span
                                            _ngcontent-serverapp-c126=""
                                            class="inline-flex relative top-0 text-xs leading-4 text-gray-900"
                                            style="list-style: outside;"
                                        >sat/vB</span
                                        >
                                    </div>
                                    <span
                                        _ngcontent-serverapp-c126=""
                                        class="block relative top-0 text-xs leading-5 text-gray-900"
                                        style="list-style: outside;"
                                    ></span>
                                </div>
                            </div>
                            <div
                                _ngcontent-serverapp-c126=""
                                class="my-0 mx-auto w-24"
                                style="list-style: outside;"
                            >
                                <div
                                    _ngcontent-serverapp-c126=""
                                    class="mb-0 text-xl leading-8"
                                    style="list-style: outside;"
                                >
                                    <div
                                        _ngcontent-serverapp-c126=""
                                        class="m-auto leading-7 border-b border-gray-200 border-solid text-gray-900"
                                        style="list-style: outside;"
                                    >
                                        {{ $fastestFee }}
                                        <span
                                            _ngcontent-serverapp-c126=""
                                            class="inline-flex relative top-0 text-xs leading-4 text-gray-900"
                                            style="list-style: outside;"
                                        >sat/vB</span
                                        >
                                    </div>
                                    <span
                                        _ngcontent-serverapp-c126=""
                                        class="block relative top-0 text-xs leading-5 text-gray-900"
                                        style="list-style: outside;"
                                    ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </app-fees-box>
            </div>

        </div>
    </div>
</div>

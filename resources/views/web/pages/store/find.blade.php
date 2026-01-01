<x-web.main-layout>
    
    {{-- 1. HEADER --}}
    {{-- CONSISTENCY CHECK: Padding pb-12, Title Uppercase 3XL --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Store Locator') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Find a Store') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Locate the nearest official Pumpman distributor or service center to ensure authenticity and expert support.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAP DASHBOARD CONTAINER --}}
    {{-- CONSISTENCY CHECK: Rounded 2.5rem, Shadow 2xl, Floating effect --}}
    <section class="bg-brand-gray pb-24 relative z-0"
        x-data="storeLocator({ 
            stores: {{ Js::from($stores) }}, 
            defaultLat: -6.2088, 
            defaultLng: 106.8456 
        })"
        x-init="initMap()"
    >
        <div class="container mx-auto px-4 md:px-6 h-[800px]">
            
            <div class="flex flex-col lg:flex-row h-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-200/60">
                
                {{-- LEFT: SIDEBAR LIST --}}
                <div class="w-full lg:w-[400px] xl:w-[450px] flex flex-col h-[500px] lg:h-full bg-white border-r border-gray-200 z-20 relative order-2 lg:order-1">
                    
                    {{-- Search Header --}}
                    <div class="p-6 border-b border-gray-100 bg-white flex-shrink-0">
                        <form action="{{ route('stores.index') }}" method="GET" class="space-y-4">
                            <div class="relative group">
                                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-brand-primary transition"></i>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search city or store name...') }}" 
                                    class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-brand-primary focus:ring-1 focus:ring-brand-primary rounded-xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-900 transition placeholder-gray-400">
                            </div>
                            
                            <button type="button" @click="getUserLocation()" class="w-full bg-brand-dark text-white rounded-xl px-4 py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-primary transition flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                <i data-lucide="crosshair" class="w-4 h-4"></i> {{ __('Use My Location') }}
                            </button>
                        </form>
                    </div>

                    {{-- Store List --}}
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-brand-gray/30 custom-scrollbar">
                        
                        @if($stores->isEmpty())
                            <div class="text-center py-16 px-6">
                                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="map-off" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-lg">{{ __('No locations found') }}</h3>
                                <p class="text-sm text-gray-500 mt-2">{{ __('Try adjusting your search area or keywords.') }}</p>
                                <a href="{{ route('stores.index') }}" class="inline-block mt-4 text-brand-primary text-sm font-bold hover:underline">{{ __('View All Locations') }}</a>
                            </div>
                        @endif

                        <template x-for="store in stores" :key="store.id">
                            <div class="p-5 rounded-2xl border cursor-pointer transition-all duration-200 group relative overflow-hidden"
                                :class="activeStoreId === store.id ? 'border-brand-primary bg-white ring-1 ring-brand-primary shadow-lg z-10' : 'border-gray-200 bg-white hover:border-brand-primary/50 hover:shadow-md'"
                                @click="focusStore(store)">
                                
                                {{-- Active Indicator Strip --}}
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-primary transition-opacity duration-200"
                                    :class="activeStoreId === store.id ? 'opacity-100' : 'opacity-0'"></div>

                                <div class="flex justify-between items-start mb-2 pl-3">
                                    <h3 class="font-bold text-lg text-slate-900 leading-tight" x-text="store.name"></h3>
                                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider flex-shrink-0 ml-2"
                                        :class="store.type === 'flagship' ? 'bg-brand-dark text-white' : 'bg-gray-100 text-gray-500'"
                                        x-text="store.type"></span>
                                </div>
                                
                                <p class="text-sm text-slate-500 mb-4 leading-relaxed pl-3">
                                    <span x-text="store.address"></span><br>
                                    <span class="font-medium text-slate-700" x-text="store.city + ', ' + store.province"></span>
                                </p>
                                
                                <div class="flex items-center justify-between pl-3 pt-3 border-t border-gray-50">
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                                        <span class="flex items-center gap-1.5" x-show="store.phone">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-primary"></i> <span x-text="store.phone"></span>
                                        </span>
                                    </div>
                                    
                                    <a :href="store.gmaps_link" target="_blank" 
                                    class="text-xs bg-gray-100 text-slate-700 px-3 py-1.5 rounded-lg font-bold hover:bg-brand-primary hover:text-white transition flex items-center gap-1.5 group-hover/btn">
                                        {{ __('Directions') }} <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                                    </a>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

                {{-- RIGHT: MAP AREA --}}
                <div class="flex-1 relative h-[400px] lg:h-full bg-gray-200 order-1 lg:order-2">
                    <div id="map" class="w-full h-full grayscale-map"></div>
                    
                    {{-- Map Legend Overlay --}}
                    <div class="absolute top-6 right-6 bg-white/95 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-gray-100 hidden md:block z-10">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">{{ __('Legend') }}</h4>
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <img src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png" class="w-5 h-auto opacity-80" alt="Pin">
                                <span class="text-xs font-bold text-slate-700">{{ __('Pumpman Partner') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full bg-blue-500 border-2 border-white shadow-sm block ml-0.5"></span>
                                <span class="text-xs font-bold text-slate-700">{{ __('Your Position') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function(g){var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
                key: "{{ config('services.google_maps.key') }}", 
                v: "weekly",
            });
        </script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('storeLocator', (config) => ({
                    stores: config.stores,
                    map: null,
                    markers: [],
                    activeStoreId: null,
                    infoWindow: null,

                    async initMap() {
                        try {
                            const { Map } = await google.maps.importLibrary("maps");
                            const { Marker } = await google.maps.importLibrary("marker");
                            
                            this.map = new Map(document.getElementById("map"), {
                                center: { lat: config.defaultLat, lng: config.defaultLng },
                                zoom: 12,
                                mapId: "63681a10d4faf41da4a9bff9", // Ganti jika punya custom map style sendiri
                                mapTypeControl: false,
                                fullscreenControl: false,
                                streetViewControl: false,
                                zoomControlOptions: {
                                    position: google.maps.ControlPosition.RIGHT_CENTER,
                                },
                            });

                            this.infoWindow = new google.maps.InfoWindow();

                            this.stores.forEach(store => {
                                if(store.latitude && store.longitude) {
                                    
                                    const marker = new Marker({
                                        position: { lat: parseFloat(store.latitude), lng: parseFloat(store.longitude) },
                                        map: this.map,
                                        title: store.name,
                                    });

                                    marker.addListener("click", () => {
                                        this.focusStore(store);
                                        this.showInfoWindow(marker, store);
                                    });

                                    this.markers.push({ id: store.id, marker: marker });
                                }
                            });

                            // Auto fit bounds jika ada markers
                            if (this.markers.length > 0) {
                                const bounds = new google.maps.LatLngBounds();
                                this.markers.forEach(m => {
                                    bounds.extend(m.marker.getPosition());
                                });
                                this.map.fitBounds(bounds);
                            }
                        } catch (error) {
                            console.error("Google Maps Error:", error);
                        }
                    },

                    getDirectionsUrl(store) {
                        if (store.gmaps_link) return store.gmaps_link;
                        if (store.latitude && store.longitude) {
                            return `http://googleusercontent.com/maps.google.com/?q=${store.latitude},${store.longitude}`;
                        }
                        const query = encodeURIComponent(`${store.name} ${store.address} ${store.city}`);
                        return `http://googleusercontent.com/maps.google.com/?q=${query}`;
                    },

                    focusStore(store) {
                        this.activeStoreId = store.id;
                        if (this.map && store.latitude && store.longitude) {
                            const pos = { lat: parseFloat(store.latitude), lng: parseFloat(store.longitude) };
                            this.map.panTo(pos);
                            this.map.setZoom(15);
                            
                            const target = this.markers.find(m => m.id === store.id);
                            if(target) {
                                this.showInfoWindow(target.marker, store);
                            }
                        }
                    },

                    showInfoWindow(marker, store) {
                        const dirLink = this.getDirectionsUrl(store);
                        const getDirectionsText = "{{ __('Get Directions') }}";
                        
                        // Custom Info Window Styling (Industrial Clean)
                        const contentString = `
                            <div class="p-1 font-sans min-w-[220px]">
                                <h3 class="font-bold text-sm mb-1 text-slate-900 leading-tight">${store.name}</h3>
                                <p class="text-xs text-slate-500 mb-3 leading-snug">${store.address}</p>
                                <a href="${dirLink}" target="_blank" class="text-[10px] uppercase tracking-wider bg-slate-900 text-white px-3 py-2 rounded hover:bg-green-600 font-bold inline-flex items-center gap-1 transition shadow-sm w-full justify-center">
                                    ${getDirectionsText} <span>→</span>
                                </a>
                            </div>
                        `;
                        this.infoWindow.setContent(contentString);
                        this.infoWindow.open(this.map, marker);
                    },

                    async getUserLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                async (position) => {
                                    const pos = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude,
                                    };
                                    this.map.setCenter(pos);
                                    this.map.setZoom(14);
                                    
                                    const { Marker } = await google.maps.importLibrary("marker");
                                    
                                    // Custom Blue Dot for User Location
                                    new Marker({
                                        position: pos,
                                        map: this.map,
                                        title: "{{ __('Your Location') }}",
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 10,
                                            fillColor: "#3B82F6",
                                            fillOpacity: 1,
                                            strokeWeight: 2,
                                            strokeColor: "white",
                                        },
                                    });
                                },
                                (error) => {
                                    alert("{{ __('Failed to get location. Please enable location services.') }}");
                                }
                            );
                        } else {
                            alert("{{ __('Browser does not support geolocation.') }}");
                        }
                    }
                }));
            });
        </script>
    @endpush

</x-web.main-layout>
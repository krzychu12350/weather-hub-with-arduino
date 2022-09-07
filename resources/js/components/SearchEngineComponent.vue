<template>
    <div
        class="search-engine-container flex-column">
        <div class="search-box d-flex flex-column">
            <div class="d-flex search-input-container">
                <div
                    :class="{ visible }"
                    class="search-input">
                    <input
                        type="text"
                        ref="headline"
                        @keypress="isLetter($event)"
                        @input="debounceSearch"
                        placeholder="Search"
                    >
                </div>
                <div
                    @click="this.visible = !this.visible"
                    class="search-icon d-flex justify-content-center align-items-center">
                    <box-icon
                        v-if="this.isSearching"
                        @click="resetInput"
                        name='x'
                        color="white"
                    />
                    <box-icon
                        v-else
                        @click="resetInput"
                        name='search'
                        color="white"
                    />
                </div>
            </div>
            <div>
                <div
                    v-click-outside="onClickOutside"
                    class="searched-place-container w-100">
                    <div
                        class="searched-place"
                        v-if="typing">
                        Searching...
                    </div>
                    <div
                        class="searched-place"
                        v-if="noResults"
                    >
                        Sorry, no results for {{ search }}
                    </div>
                    <div
                        v-if="routeName === 'Home'"
                        v-for="(p, i) in results.slice(0, 5)"
                        :key="p.id"
                        @click='getWeatherDataForSelectedPlace(p.id)'
                        class="searched-place"
                    >
                        <div class="d-flex justify-content-between">
                            <span>{{ p.name }} {{ p.country }}</span>
                            <font-awesome-icon
                                icon="fa-solid fa-location-dot"
                                color="black"
                            />
                        </div>
                    </div>
                    <div
                        v-if="routeName === 'AddingFavouritePlacePage'"
                        v-for="(p, i) in results.slice(0, 5)"
                        :key="p.id"
                        @click='addPlaceToFavourites(p)'
                        class="searched-place"
                    >
                        <div class="d-flex justify-content-between">
                            <span>{{ p.name }} {{ p.country }}</span>
                            <font-awesome-icon
                                icon="fa-solid fa-location-dot"
                            />
                        </div>
                    </div>
                    <div
                        v-if="routeName === 'SelectPrimaryPlacePage'"
                        v-for="(p, i) in results.slice(0, 5)"
                        :key="p.id"
                        @click='triggerUpdateOfUserPrimaryPlace(String(p.id))'
                        class="searched-place"
                    >
                        <div class="d-flex justify-content-between">
                            <span>{{ p.name }} {{ p.country }}</span>
                            <font-awesome-icon
                                icon="fa-solid fa-location-dot"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import placesData from "../assets/cities.list.json";
import {useRouter} from 'vue-router';
import {computed, ref} from "vue";
import {useVueFuse} from "vue-fuse";
import UserService from "../services/user-service";
import vClickOutside from 'click-outside-vue3'

export default {
    name: "SearchEngine",
    emits: [
        'passSearchedPlaceId',
    ],
    directives: {
        clickOutside: vClickOutside.directive
    },
    setup() {
        const routeName = computed(() => {
            return useRouter().currentRoute.value.name;
        })
        const headline = ref(null);

        const options = {
            keys: [{name: 'name', weight: 2}],
            includeScore: true,
            threshold: 0.0,
        }
        const {search, results, noResults} = useVueFuse(placesData, options)

        return {
            search,
            results,
            noResults,
            routeName,
            headline
        }
    },
    data() {
        return {
            keyword: null,
            Places: placesData,
            searched: '',
            awaitingSearch: false,
            searchedPlaces: [],
            message: null,
            typing: null,
            debounce: null,
            debouncedWatch: null,
            isSearching: false,
            visible: false,
        };
    },
    methods: {
        getWeatherDataForSelectedPlace(placeId) {
            this.$emit("passSearchedPlaceId", placeId)
            this.emitter.emit('passSearchedPlaceId',
                {'value': placeId})
        },
        debounceSearch(event) {
            this.message = null
            this.typing = 'You are typing...'
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                this.typing = null
                this.search = event.target.value
                this.isSearching = !this.isSearching
                this.message = this.search
            }, 600)

        },
        addPlaceToFavourites(place) {
            UserService.addUserFavouritePlace(place)
            this.$router.push('/')
        },
        triggerUpdateOfUserPrimaryPlace(placeId) {
            UserService.updateUserPrimaryPlace(placeId)
            this.$router.push('/')
        },
        onClickOutside() {
            if (this.message !== "") {
                this.search = ""
                this.headline.value = ""
            }
        },
        resetInput() {
            this.isSearching = !this.isSearching
            this.headline.value = ""
            this.search = ""
        },
        isLetter(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ\s]/.test(char)) return true;
            else e.preventDefault();
        },
    }
}
</script>

<style lang="scss">

.searched-place {
    cursor: pointer;
    padding: 1em;
    min-height: 2em;

    &:hover {
        background: #ededed;
    }
}

.searched-place-container {
    background-color: white;
    z-index: 3;
    position: relative;
}

.search-input > input {
    height: 3em;
}

.search-box {
    outline: 0;
    float: left;
    -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    -webkit-border-radius: 4px;

}

.search-box > .search-input {
    width: 100px;
    height: 3em;
    padding: 0 16px;
    background-color: #FFF;
    border: 0;
    float: left;

    &:focus {
        outline: none !important;
    }
}

.search-box > .search-input:focus {
    outline: 0;
    background-color: #FFF;
}

.search-icon {
    width: 3em;
    height: 3em;
    outline: none !important;
    background: linear-gradient(180deg, #08C8F6, #2698f8);
    margin: 0;
    font-size: initial;
    max-width: 100px;
}

.search-icon:hover {
    background-color: #FFF;
}

.search-box > .search-icon:hover {
    background-color: #2698F8FF;
    cursor: pointer;
}

@media only screen and (max-width: 600px) {
    .visible > input {
        display: block !important;
    }

    .search-input > input {
        max-width: 150px;
        display: none;
    }
}
</style>

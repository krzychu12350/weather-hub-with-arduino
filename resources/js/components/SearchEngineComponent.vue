<template>
    <div class="search-engine-container flex-column">
        <!--<input type="text" v-model="keyword">
        -->



        <!--
        <span v-if="typing">You are typing || Searching....</span>
        <span v-if="message">You typed: {{message}}</span>
        <input type="text" @input="debounceSearch">

        <p class="position-absolute" v-if="noResults">Sorry, no results for {{search}}</p>
        <div class="searched-place-container w-25">
            <div v-if="routeName === 'Home'"
                 v-for="(p, i) in results.slice(0, 5)"
                 :key="p.id"
                 @click='getWeatherDataForSelectedPlace(p.id)'
                 class="searched-place">
                {{ p.id }} {{ p.name }} {{ p.country }}
            </div>
            <div
                v-if="routeName === 'AddingFavouritePlacePage'"
                v-for="(p, i) in results.slice(0, 5)"
                :key="p.id"
                @click='addPlaceToFavourites(p)'
                class="searched-place">
                {{ p.id }} {{ p.name }} {{ p.country }}
            </div>
        </div>
        https://codepen.io/erat/pen/NWWOyVQ
        -->

        <div class="search-box d-flex flex-column">
            <div class="d-flex search-input-container">
                <div :class="{ visible }" class="search-input">
                    <input type="text"
                           ref="headline"
                           v-on:keypress="isLetter($event)"
                           @input="debounceSearch"
                           placeholder="Search">
                </div>

                <div @click="this.visible = !this.visible" class="search-icon d-flex justify-content-center align-items-center">
                    <box-icon v-if="this.isSearching" @click="resetInput" name='x' color="white"></box-icon>
                    <box-icon v-else @click="resetInput" name='search' color="white"></box-icon>

                </div>
            </div>

            <div>

                <div
                    v-click-outside="onClickOutside"
                    class="searched-place-container w-100">
                    <!--<span v-if="message">You typed: {{message}}</span>-->
                    <div class="searched-place" v-if="typing">Searching...</div>
                    <div class="searched-place" v-if="noResults">Sorry, no results for {{search}}</div>

                    <div v-if="routeName === 'Home'"
                         v-for="(p, i) in results.slice(0, 5)"
                         :key="p.id"
                         @click='getWeatherDataForSelectedPlace(p.id)'
                         class="searched-place">
                        <div class="d-flex justify-content-between">
                            <span>{{ p.id }} {{ p.name }} {{ p.country }}</span>
                            <font-awesome-icon
                                icon="fa-solid fa-location-dot"
                                color="black" />
                        </div>


                    </div>
                    <div
                        v-if="routeName === 'AddingFavouritePlacePage'"
                        v-for="(p, i) in results.slice(0, 5)"
                        :key="p.id"
                        @click='addPlaceToFavourites(p)'
                        class="searched-place">
                        {{ p.id }} {{ p.name }} {{ p.country }}
                        <font-awesome-icon icon="fa-solid fa-location-dot" />
                    </div>
                </div>


            </div>



        </div>










        <!--
        <input type="text" class="form-input" @input="debounceSearch" placeholder="Search">
        <span v-if="typing">You are typing(Searing...)</span>
        <span v-if="message">You typed: {{message}}</span>
        -->



        <!--
        <ul v-if="Cities.length > 0">
            <li v-for="city in Cities" :key="city.id" v-text="city.name"></li>
        </ul>

        <h4 v-for="city in this.filteredCities">
            {{city.id}}
            {{city.name}}
            <br>
        </h4>

        <h4>Pure json</h4>
        <h5>{{this.searched}}</h5>


        <div class="" v-for="city in this.searchedCities">
            {{city.id}}
            {{city.name}}
            <br>
        </div>
        -->

        <!--
        <div v-if="message">
            <div class="serached-places">
                <div class="bg-danger border border-primary mb-1" v-for="place in this.searchedPlaces">
                    <div v-if="routeName === 'Home'" class="searched-place" @click='getWeatherDataForSelectedPlace(place.id)' :key='place.id'>
                        <span class="cursor-pointer">{{place.id}} {{place.name}}</span>
                    </div>
                    <div v-else class="searched-place" @click='addPlaceToFavourites(place)' :key='place.id'>
                        <span class="cursor-pointer">{{place.id}} {{place.name}} {{place.state}} {{place.country}}</span>
                    </div>


                </div>
            </div>



        </div>
          -->





    </div>
</template>

<script>
import placesData from "../assets/cities.list.json";
import { useRouter } from 'vue-router';
import {computed, ref} from "vue";
import fuse from "fuse.js"
import {debounce} from "lodash";
import { JsonSearch, ResultList, ResultListItem, ResultTitle, SearchInput, SearchResults } from 'vue-json-search'
import {useVueFuse} from "vue-fuse";
import UserService from "../services/user-service";
import vClickOutside from 'click-outside-vue3'
export default{
    name: "SearchEngine",
    emits: [
        'passSearchedPlaceId',
        ],
    directives: {
        clickOutside: vClickOutside.directive
    },
    setup () {
        const routeName = computed(() => {
            return useRouter().currentRoute.value.name;
        })
        const headline = ref(null);

        const myList = [
            {'name': 'aaaa'},
            {'name': 'bbbb'},
            {'name': 'cccc'},
            {'name': 'abc'},
            {'name': 'xyz'},
            {'name': 'aaaa'},
            {'name': 'bbbb'},
            {'name': 'cccc'},
            {'name': 'abc'},
            {'name': 'xyz'},
            {'name': 'aaaa'},
            {'name': 'bbbb'},
            {'name': 'cccc'},
            {'name': 'abc'},
            {'name': 'xyz'},
            {'name': 'aaaa'},
            {'name': 'bbbb'},
            {'name': 'cccc'},
            {'name': 'abc'},
            {'name': 'xyz'},
            {'name': 'aaaa'},
            {'name': 'bbbb'},
            {'name': 'cccc'},
            {'name': 'abc'},
            {'name': 'xyz'},
            ]

        const options = {
            keys: [{name: 'name', weight: 2}],
            includeScore: true,
            //minMatchCharLength: 4,
            threshold:0.0,
            //useExtendedSearch: true
        }
        const myList2 = placesData

        const { search, results, noResults} = useVueFuse(myList2, options)

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

    watch: {


        /*
      searchCities() {
          return this.filteredCities()
      }

      keyword(after, before) {
          //console.log(this.keyword)

          //console.log(this.filteredName)
          //this.getResults();
          //this.filteredList()
      },*/

        /*
        searched() {
            if (!this.awaitingSearch) {
                setTimeout(() => {
                    //this.fetchResults({ query: this.search });
                    console.log("test")
                    console.log(this.filteredName)
                    this.awaitingSearch = false;
                }, 1000); // 1 sec delay
            }
            this.awaitingSearch = true;
        },
        */


    },

    computed: {
        filteredPlaces() {
            if(this.message) {
                //console.log(this.message)
                return this.Places
                    .filter((place) => {
                        return  place.name.match(this.message);
                    })

            }
        },
            /*
     return this.Cities
         .filter((x) => {
             let match = true;
             console.log(x);
             for(let i in this.searchedCities){
                 console.log(x[i])
                 //console.log(this.searchedCities)
                 if(!x[i].toLowerCase().match(this.searchedCities[i].toLowerCase())) match = false;
             }
             return match;
         })
         */


    },
    methods: {
        getWeatherDataForSelectedPlace(placeId) {
            //this.$emit("passSearchedPlaceId", placeId)
            this.emitter.emit('passSearchedPlaceId',
                {'value': placeId})
            //alert(placeiId)
            //this.$root.$emit('a-far-away-event', 'Adnan')
        },
        debounceSearch(event) {
            this.message = null
            this.typing = 'You are typing...'
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                this.typing = null
                this.search = event.target.value

                this.isSearching = !this.isSearching
                //this.searchedPlaces = this.filteredPlaces
                //console.log(this.results)
                this.message = this.search
            }, 600)

        },
        addPlaceToFavourites(place) {
            //alert("dodawanie miasta do ulubionych "  + place.id + place.name)
            UserService.addUserFavouritePlace(place)
            this.$router.push('/favourites')

        },
        onClickOutside (event) {


            //this.$refs["headline"].reset
            //console.log()
            if(this.message !== "") {
                //console.log('Clicked outside. Event: ', event)
                //console.log(this.message)
                this.search = ""
                this.headline.value = ""
            }

            //this.headline.value = ""
        },
        resetInput () {
            this.isSearching = !this.isSearching
            this.headline.value = ""
            this.search = ""
        },
        isLetter(e) {
            let char = String.fromCharCode(e.keyCode);
            if(/[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ\s]/.test(char)) return true;
            else e.preventDefault();
        },
        getResults() {

            /*
            this.axios.get("../assets/cities.list.json")
                .then(res => console.log(res.data))
                .catch(err => console.log(err))
            */
            /*
            fetch("../assets/cities.list.json")
                .then(r => r.json())
                .then(json => {
                    this.Cities = json
                })
            */
            //console.log(citiesData[0])
            /*
            axios.get('cities.list.json', { params: { keyword: this.keyword } })
                .then(res => this.Cities = res.data)
                .then(console.log(res.data))
                .catch(error => {});
                 return user.value.filter((item) => {
                    return item.name.toLowerCase().includes(search.value);
                  })
             */
            //this.search = this.keyword
            //console.log(this.keyword)
            //console.log(this.Cities[0].name)

            //this.search = this.Cities.find(item => item.name===this.keyword)
            //let data = this.filteredList();
            //console.log(data)
            //console.log(this.search)
            /*
            this.Cities.filter((item) => {
                console.log(item.name == 'Nisko')
                //console.log('test')
                //return 'test'
            });
            */
        }
    }
}
</script>

<style lang="scss">
.search-engine-container {
   // max-width: 14.5em;
}
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
    //margin-top: 3em;

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

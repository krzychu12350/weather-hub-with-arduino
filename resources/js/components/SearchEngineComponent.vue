<template>
    <div>
        <!--<input type="text" v-model="keyword">
        -->
        <input type="text" class="form-input" @input="debounceSearch" placeholder="Search">
        <span v-if="typing">You are typing(Searing...)</span>
        <span v-if="message">You typed: {{message}}</span>
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

     -->
        <h4 v-for="city in this.searchedCities">
            {{city.id}}
            {{city.name}}
            <br>
        </h4>


    </div>
</template>

<script>
import citiesData from "../assets/cities.list.json";
export default {
    name: "Register",
    data() {
        return {
            keyword: null,
            Cities: citiesData,
            searched: '',
            awaitingSearch: false,

            searchedCities: [],
            message: null,
            typing: null,
            debounce: null
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
        filteredCities() {
            if(this.message) {
                //console.log(this.message)
                return this.Cities
                    .filter((city) => {
                        return  city.name.match(this.message);
                    })

            }
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
    },
    methods: {

        debounceSearch(event) {
            this.message = null
            this.typing = 'You are typing...'
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                this.typing = null
                this.message = event.target.value

                this.searchedCities = this.filteredCities

            }, 600)

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

<style scoped>

</style>

<template>
        <div
            class="top-bar d-flex
            justify-content-between"
        >
            <div class="d-flex">
                <div
                    class="hamburger-container
                    d-flex align-items-center
                    justify-content-center"
                    @click="triggerTogglingOfSidebar"
                >
                    <a class="navbar-brand" href="#">
                        <font-awesome-icon
                            class="hamburger-icon"
                            icon="fa-solid fa-bars"
                            color="white"
                        />
                    </a>
                </div>
                <div
                    class="d-flex align-items-center"
                >
                    <header>
                        <router-link
                            :to="{ name: 'Home' }"
                        >
                            <div class="image-text">
                                <div
                                    class="text logo-text ms-2"
                                >
                                    <span
                                        class="name text-white"
                                    >
                                        {{ nameOfTheSubpage }}
                                    </span>
                                </div>
                            </div>
                        </router-link>
                    </header>
                </div>
            </div>
            <div
                v-if="routeName === 'Home'"
                class="search-div"
            >
                <SearchEngineComponent />
            </div>
        </div>
</template>

<script>

import SearchEngineComponent from "./SearchEngineComponent.vue";
import { useRouter } from 'vue-router';
import {computed} from "vue";

export default {
    name: "TopBarComponent",
    components: {
        SearchEngineComponent,
    },
    props: {
        nameOfTheSubpage: String,
        required: false,
    },
    setup () {
        const routeName = computed(() => {
            return useRouter().currentRoute.value.name;
        })

        return { routeName }
    },
    methods: {
        triggerTogglingOfSidebar () {
            this.emitter.emit('triggerToggling')
        }
    },
}
</script>

<style lang="scss">
.top-bar {
    height: 3em;
    max-height: 4em;
    background: linear-gradient(180deg, #08C8F6, #2698f8);
}

.search-div {
    margin-right: 0em;
}

.hamburger-container {
    width: 80px;
    &:hover {
        cursor: pointer;
       background-color: rgba(89, 165, 211, 0.71);
    }
}

.hamburger-icon {
    font-size: 1.5em;
}

.image-text {
    display: flex;
    align-items: center;

    .name {
        margin-top: 2px;
        font-size: 1.5em;
        font-weight: 500;
    }

    .profession {
        font-size: 16px;
        margin-top: -2px;
        display: block;
    }
}
</style>

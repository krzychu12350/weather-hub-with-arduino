<template>
    <nav
        class="sidebar position-relative"
        :class="[ isCollapsed ? 'close' : '' ]"
    >
        <div class="menu-bar">
            <div class="menu">
                <li class="nav-link">
                    <router-link
                        :to="{ name: 'Home' }"
                    >
                        <div class="icon">
                            <box-icon
                                type="regular"
                                name="home-alt"
                                color="white"
                            ></box-icon>
                        </div>
                        <span
                            class="text nav-text"
                        >Forecast
                        </span>
                    </router-link>
                </li>
                <li class="nav-link">
                    <router-link
                        :to="{ name: 'FavouritePlacesPage' }"
                    >
                        <div
                            class="icon d-flex
                            justify-content-center">
                            <box-icon
                                type="regular"
                                name="heart"
                                color="white"
                            ></box-icon>
                        </div>
                        <span
                            class="text nav-text"
                        >
                            Favourite places
                        </span>
                    </router-link>
                </li>
            </div>
            <div class="bottom-content">
                <li class="nav-link">
                    <router-link
                        :to="{ name: 'SettingsPage' }"
                    >
                        <div
                            class="icon d-flex
                            justify-content-center">
                            <font-awesome-icon
                                icon="fa-solid fa-gear"
                                color="white"
                                size="sm"
                            />
                        </div>
                        <span
                            class="text nav-text">
                            Settings
                        </span>
                    </router-link>
                </li>
                <li class="nav-link">
                    <a
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#logout-confirmation"
                    >
                        <div
                            class="icon d-flex
                            justify-content-center"
                        >
                            <box-icon
                                type="regular"
                                name="log-out"
                                color="white"
                            />
                        </div>
                        <span
                            class="text nav-text"
                        >
                            Logout
                        </span>
                    </a>
                </li>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "SidebarComponent",
    data() {
        return {
            isCollapsed: true,
            isDisplay: false,
            info: null,
        }
    },
    created() {
        this.emitter.on('triggerToggling', () => {
            this.toggleSidebar()
        })
    },
    methods: {
        toggleSidebar() {
            this.isCollapsed = !this.isCollapsed;
            this.isDisplay = !this.isDisplay;
        }
    }
}
</script>

<style lang="scss">


/* ===== Colors ===== */
$body-color: #E4E9F7;
/*$primary-color: #695CFE;*/
$primary-color: #2698f8;

$primary-color-light: #F6F5FF;
$toggle-color: #DDD;
$sidebar-color: #FFF;
$text-color: #707070;


/* ====== Transition ====== */
$tran-03: all 0.2s ease;
$tran-03: all 0.3s ease;
$tran-04: all 0.3s ease;
$tran-05: all 0.3s ease;

$side-nav-width: 80px;

:root {
}

@mixin minWidth_B_radius() {
    min-width: 60px;
    border-radius: 6px;
}

@mixin color_transition($f_color, $trans) {
    color: white;
    transition: $trans;
}

@mixin flex_property($flex-direction, $align, $justify) {
    display: flex;
    @if $flex-direction != null {
        flex-direction: $flex-direction;
    }
    @if $align != null {
        align-items: $align;
    }
    @if $justify != null {
        justify-content: $justify;
    }
}

@mixin changetheme() {
    $body-color: #18191a;
    $sidebar-color: #242526;
    $primary-color: #3a3b3c;
    $primary-color-light: #3a3b3c;
    $toggle-color: #fff;
    $text-color: #ccc;
}

::root {
    // var(--side-nav-width ,$side-nav-width);
}

body {
    min-height: 100vh;
    //background-color: $body-color;
    transition: $tran-05;
}

::selection {
    background-color: $primary-color;
    color: #fff;
}

body.dark {
    @include changetheme();

    .sidebar {
        header {
            .toggle {
                color: $sidebar-color;
            }
        }

        li {
            a {
                &:hover {
                    .icon {
                        color: $text-color;
                    }

                    .text {
                        color: $text-color;
                    }
                }
            }
        }

        .mode {
            .sun-moon {
                i {
                    &.sun {
                        opacity: 1;
                    }

                    &.moon {
                        opacity: 0;
                    }
                }
            }
        }

        .switch {
            ::before {
                left: 20px;
            }
        }
    }

    .primary-place-forecast .text {
        //color: $text-color;
    }
}

.sidebar {
    /*position: fixed;*/
    top: 0px;
    left: 0px;
    height: 100%;
    width: 250px;
    padding: 10px 14px;
    //background: $sidebar-color;
    background: linear-gradient(to right, #08C8F6, #2698f8);
    transition: $tran-05;
    z-index: 2;

    @media only screen and (max-width: 768px) {
        &.close {
            width: 100%;
        }
    }

    &.close {
        width: 80px;
        $side-nav-width: 80 px÷;

        .text {
            // opacity: 0;
            display: none;
        }

        .toggle {
            transform: translateY(-50%) rotate(0deg);
        }

        .primary-place-forecast {
            //left: var(--side-nav-width, $side-nav-width);
        }
    }

    li {
        height: 50px;
        list-style: none;
        display: flex;
        align-items: center;
        margin-top: 10px;

        &.search-box {
            border-radius: 6px;
            //background: $primary-color-light;
            cursor: pointer;
            transition: $tran-05;

            input {
                height: 100%;
                width: 100%;
                outline: none;
                border: none;
                //background: $primary-color-light;
                color: white;
                border-radius: 6px;
                font-size: 17px;
                font-weight: 500;
                transition: $tran-05;
            }
        }

        a {
            list-style: none;
            height: 100%;
            width: 100%;
            background: transparent;
            @include flex_property(null, center, null);
            border-radius: 6px;
            text-decoration: none;
            transition: $tran-03;

            &:hover {
                background: $primary-color;

                .icon {
                    color: $sidebar-color;
                }

                .text {
                    color: $sidebar-color;
                }
            }
        }

    }

    header {
        .image {
            display: flex;
            align-items: center;
            justify-content: center;
            @include minWidth_B_radius();

            img {
                width: 40px;
                border-radius: 6px;
            }
        }

        .image-text {
            display: flex;
            align-items: center;

            .name {
                margin-top: 2px;
                font-size: 18px;
                font-weight: 600;
            }

            .profession {
                font-size: 16px;
                margin-top: -2px;
                display: block;
            }
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .toggle {
            position: absolute;
            top: 50%;
            right: -25px;
            transform: translateY(-50%) rotate(180deg);
            height: 25px;
            width: 25px;
            background: $primary-color;
            color: $sidebar-color;
            border-radius: 50%;
            @include flex_property(null, center, center);
            font-size: 22px;
            cursor: pointer;
            transtion: $tran-05;
        }
    }

    .icon {
        min-width: 60px;
        border-radius: 6px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        @include minWidth_B_radius();
        @include color_transition($text-color, $tran-03);
    }

    .text {
        font-size: 17px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 1;
        @include color_transition($text-color, $tran-03);
    }

    .menu-bar {
        height: calc(100% - 10px);
        @include flex_property(column, null, space-between);

        &::-webkit-scrollbar {
            display: none;
        }

        .mode {
            border-radius: 6px;
            //background-color: $primary-color-light;
            position: relative;
            transition: $tran-05;

            .sun-moon {
                height: 50px;
                width: 60px;

                i {
                    position: absolute;

                    &.sun {
                        opacity: 0;
                    }
                }
            }
        }

        .bottom-content {

            .toggle-switch {
                position: absolute;
                right: 0;
                height: 100%;
                min-width: 60px;
                @include flex_property(null, center, center);
                border-radius: 6px;
                cursor: pointer;

                .switch {
                    position: relative;
                    height: 22px;
                    width: 40px;
                    border-radius: 25px;
                    background-color: var(--toggle-color);
                    transition: var(--tran-05);

                    &::before {
                        content: '';
                        position: absolute;
                        height: 15px;
                        width: 15px;
                        border-radius: 50%;
                        top: 50%;
                        left: 5px;
                        transform: translateY(-50%);
                        background-color: $sidebar-color;
                        transition: $tran-04;
                    }
                }
            }
        }
    }
}
</style>

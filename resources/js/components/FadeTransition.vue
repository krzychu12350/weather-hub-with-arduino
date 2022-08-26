<template>
    <transition name="fade"
                enter-active-class="fadeIn"
                leave-active-class="fadeOut"
                v-bind="$attrs"
                v-on="hooks">
        <slot></slot>
    </transition>
</template>
<script>
export default {
    props: {
        duration: {
            type: Number,
            default: 1000
        },
        listeners: {

        }
    },
    computed: {
        hooks() {
            return {
                beforeEnter: this.setDuration,
                afterEnter: this.cleanUpDuration,
                beforeLeave: this.setDuration,
                afterLeave: this.cleanUpDuration,
                ...this.$attrs
            };
        }
    },
    methods: {
        setDuration(el) {
            el.style.animationDuration = `${this.duration}ms`;
        },
        cleanUpDuration(el) {
            el.style.animationDuration = "";
        }
    }
};
</script>
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
.fadeIn {
    animation-name: fadeIn;
}
@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}
.fadeOut {
    animation-name: fadeOut;
}
</style>

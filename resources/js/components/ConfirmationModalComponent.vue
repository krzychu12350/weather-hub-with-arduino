<template>
    <div v-show="showModal" class="modal" id="logout-confirmation" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to log out?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" data-bs-dismiss="modal">No</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#logout-confirmation" @click.prevent="logOut">Yes</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import EventBus from "../common/EventBus";
import TokenService from "../services/token.service";

export default {
    name: "ConfirmationModalComponent",
    data () {
        return {
            showModal: true,
        }
    },
    methods: {
        logOut() {
            this.showModal = !this.showModal
            this.$store.dispatch('auth/logout');
            TokenService.removeUser()
            this.$router.go("/auth")
        },
    },
    mounted() {
        EventBus.on("logout", () => {
            this.logOut();
        });
    },
    beforeUnmount() {
        EventBus.remove("logout");
    }
}
</script>

<style scoped>

</style>

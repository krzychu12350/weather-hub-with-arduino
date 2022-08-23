<template>

    <div class="modal" id="logout-confirmation" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to log out?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" data-bs-dismiss="modal">No</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#logout-confirmation" v-on:click="logOut">Yes</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import ToastService from "../services/toast-service";

export default {
    name: "ConfirmationModalComponent",
    methods: {
        logOut() {
            this.$store.dispatch('auth/logout');
            this.$router.push("/auth");
            ToastService.showSuccessToast("You have been logged out successfully !!!")
            //this.showLogoutToast()
        },
    }
}
</script>

<style scoped>

</style>
